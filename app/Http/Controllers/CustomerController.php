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
        $filterByName = $request->name;
        $customersQuery = Customer::query()
            ->join('users', 'users.id', '=', 'customers.id')
            ->select('customers.*')
            ->orderBy('users.name');

        if ($filterByName !== null) {
            $customersQuery
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

    public function indexDeleted(Request $request): View
    {
        $filterByName = $request->name;
        $customersQuery = Customer::query()->onlyTrashed()
            ->join('users', 'users.id', '=', 'customers.id')
            ->select('customers.*')
            ->orderBy('users.name');

        if ($filterByName !== null) {
            $customersQuery
                ->where('users.name', 'like', "%$filterByName%");
        }

        $customers = $customersQuery
            ->with('user')
            ->paginate(20)
            ->withQueryString();
        return view(
            'customers.index',
            compact('customers', 'filterByName')
        )->with('tr', "trash");
    }

    public function save(Customer $customer): RedirectResponse{
        if (!$customer->trashed()){
            return view('customers.deleted')
                ->with('alert-type', 'error')
                ->with('alert-msg', "Customer \"{$customer?->user->name}\" is not in the deleted list.");;    
        }
        if ($customer->userD->trashed()){
            $customer->userD->restore();
        }
        $customer->restore();
        return redirect()->back()->with('alert-type', 'success')
        ->with('alert-msg', "Customer \"{$customer?->user->name}\" has been restored.");;
    }
 
    public function destruction (Customer $customer): RedirectResponse{
        if (!$customer->trashed()){
            return redirect()->route('customers.index')
                ->with('alert-type', 'error')
                ->with('alert-msg', "Theater \"{$customer?->user->name}\" is not in the deleted list.");
        }

        
        if ($customer->userD->photo_filename && Storage::exists('public/photos/' . $customer->userD->photo_filename)) {
            Storage::delete('public/photos/' . $customer->userD->photo_filename);
        }
        if ($customer->purchases()->count() != 0){
            $customer->purchases()->each(function ($purchase) {
                $purchase->customer_id=null;
                $purchase->save();
            });
        }
        $user = $customer->userD;
        $customer->forceDelete();
        $name = $user->name;
        $user->forceDelete();
        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', "Customer \"{$name}\" has been permanently deleted.");
    }

    public function show(Customer $customer): View
    {
        return view('customers.show')
            ->with('customer', $customer);
    }

    public function invertBlockTrash(Customer $customer): RedirectResponse
    {
        if (empty($customer)){
            return redirect()->back()
            ->with('alert-type', 'danger')
            ->with('alert-msg', "Customer non-existent");
        }
        $customer->userD->blocked = $customer->userD->blocked == 1 ? 0:1;
        $customer->userD->save();
        
        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', "Customer \"{$customer->userD->name}\" has been ". ($customer->userD->blocked ==1 ? 'blocked' : 'unblocked') );


    }

    

    public function invertBlock(Customer $customer): RedirectResponse
    {
        if (empty($customer)){
            return redirect()->back()
            ->with('alert-type', 'danger')
            ->with('alert-msg', "Customer non-existent");
        }
        $customer->user->blocked = $customer->user->blocked == 1 ? 0:1;
        $customer->user->save();
        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', "Customer \"{$customer->user->name}\" has been ". ($customer->user->blocked ==1 ? 'blocked' : 'unblocked') );
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

