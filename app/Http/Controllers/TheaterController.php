<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theater;
use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TheaterFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TheaterController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Theater::class);
    }

    public function index(): View
    {
        return view('Theaters.index')
            ->with('Theaters', Theater::orderBy('name')->paginate(20)->withQueryString());
    }

    public function create(): View
    {
        $newTheater = new Theater();
        return view('Theaters.create')
            ->with('Theater', $newTheater);
    }

    public function store(TheaterFormRequest $request): RedirectResponse
    {
        $newTheater = Theater::create($request->validated());
        $url = route('Theaters.show', ['Theater' => $newTheater]);
        $htmlMessage = "Theater <a href='$url'><u>{$newTheater->name}</u></a> ({$newTheater->abbreviation}) has been created successfully!";
        return redirect()->route('Theaters.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function edit(Theater $Theater): View
    {
        return view('Theaters.edit')
            ->with('Theater', $Theater);
    }

    public function update(TheaterFormRequest $request, Theater $Theater): RedirectResponse
    {
        $Theater->update($request->validated());
        $url = route('Theaters.show', ['Theater' => $Theater]);
        $htmlMessage = "Theater <a href='$url'><u>{$Theater->name}</u></a> ({$Theater->abbreviation}) has been updated successfully!";
        return redirect()->route('Theaters.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Theater $Theater): RedirectResponse
    {
        try {
            $url = route('Theaters.show', ['Theater' => $Theater]);

            $totalCustomers = Customer::where('Theater', $Theater->abbreviation)->count();
            if ($totalCustomers == 0) {
                $Theater->delete();
                $alertType = 'success';
                $alertMsg = "Theater {$Theater->name} ({$Theater->abbreviation}) has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $justification = match (true) {
                    $totalCustomers <= 0 => "",
                    $totalCustomers == 1 => "there is 1 Customer in the Theater",
                    $totalCustomers > 1 => "there are $totalCustomers Customers in the Theater",
                };
                $alertMsg = "Theater <a href='$url'><u>{$Theater->name}</u></a> ({$Theater->abbreviation}) cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the Theater
                            <a href='$url'><u>{$Theater->name}</u></a> ({$Theater->abbreviation})
                            because there was an error with the operation!";
        }
        return redirect()->route('Theaters.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    public function show(Theater $Theater): View
    {
        return view('Theaters.show')->with('Theater', $Theater);
    }
}
