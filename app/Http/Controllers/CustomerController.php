<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use App\Http\Requests\CustomerFormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        //$this->authorizeResource(Customer::class);
    }

    public function index(Request $request): View
    {
        $filterByName = $request->query('name');
        $customersQuery = Customer::query()
            ->join('users', 'users.id', '=', 'customers.id')
            ->select('customers.*')
            ->orderBy('users.name');

        if ($filterByName !== null) {
            $customersQuery
                ->where('users.type', 'C')
                ->where('users.name', 'like', "%$filterByName%");
        }


        $customers = $customersQuery
            ->with('user')
            ->paginate(20)
            ->withQueryString();
        return view(
            'customers.index',
            compact('customers', 'filterByName')
        );
    }

    public function show(Customer $customer): View
    {
        return view('customers.show')
            ->with('customer', $customer);
    }

    public function create(): View
    {
        $newCustomer = new Customer();
        $newUser = new User();
        $newUser->type = 'C';
        $newCustomer->user = $newUser;
        return view('customers.create')
            ->with('customer', $newCustomer);
    }



    public function store(CustomerFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $newCustomer = DB::transaction(function () use ($validatedData, $request) {
            $newUser = new User();
            $newUser->type = 'C';
            $newUser->name = $validatedData['name'];
            $newUser->email = $validatedData['email'];
            // Only sets admin field if it has permission  to do it.
            // Otherwise, admin is false
            $newUser->admin = $request->user()?->can('createAdmin', Customer::class)
                ? $validatedData['admin']
                : 0;
            // Initial password is always 123
            $newUser->password =bcrypt('123');
            $newUser->save();
            $newCustomer = new Customer();
            $newCustomer->user_id = $newUser->id;
            $newCustomer->nif = $validatedData['nif'];
            $newCustomer->save();

            if ($request->hasFile('photo_filename')) {
                $path = $request->photo_file->store('public/photos');
                $newUser->photo_filename = basename($path);
                $newUser->save();
            }
            return $newCustomer;
        });
        $newCustomer->user->sendEmailVerificationNotification();
        $url = route('customers.show', ['customer' => $newCustomer]);
        $htmlMessage = "Customer <a href='$url'><u>{$newCustomer->user->name}</u></a> has been created successfully!";
        return redirect()->route('customers.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function edit(Customer $customer): View
    {
        return view('customers.edit')
            ->with('customer', $customer);
    }


    public function update(CustomerFormRequest $request, Customer $customer): RedirectResponse
    {
        $validatedData = $request->validated();
        $customer = DB::transaction(function () use ($validatedData, $customer, $request) {
            $customer->department = $validatedData['nif'];

            $customer->save();
            $customer->user->name = $validatedData['name'];
            $customer->user->email = $validatedData['email'];
            // Only updates admin field if it has permission  to do it.
            // Otherwise, do not change it (ignore it)
            if ($request->user()?->can('updateAdmin', $customer)) {
                $customer->user->type = $validatedData['type'];
            }
            $customer->user->save();
            if ($request->hasFile('photo_file')) {
                // Delete previous file (if any)
                if ($customer->user->photo_filename &&
                    Storage::fileExists('public/photos/' . $customer->user->photo_filename)) {
                        Storage::delete('public/photos/' . $customer->user->photo_filename);
                }
                $path = $request->photo_filename->store('public/photos');
                $customer->user->photo_filename = basename($path);
                $customer->user->save();
            }
            return $customer;
        });
        $url = route('customers.show', ['customer' => $customer]);
        $htmlMessage = "customer <a href='$url'><u>{$customer->user->name}</u></a> has been updated successfully!";
        if ($request->user()->can('viewAny', customer::class)) {
            return redirect()->route('customers.index')
                ->with('alert-type', 'success')
                ->with('alert-msg', $htmlMessage);
        }
        return redirect()->back()
        ->with('alert-type', 'success')
        ->with('alert-msg', $htmlMessage);
    }
}

