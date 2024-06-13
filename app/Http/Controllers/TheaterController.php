<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theater;
use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TheaterFormRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class TheaterController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Theater::class);
    }

    public function index(): View
    {
        return view('theaters.index')
            ->with('theaters', Theater::orderBy('name')->paginate(14)->withQueryString());
    }

    public function create(): View
    {
        $theater = new Theater();
        return view('theaters.create')
            ->with('theater', $theater);
    }

    public function store(TheaterFormRequest $request): RedirectResponse
    {
        $newTheater = Theater::create($request->validated());

        if ($request->hasFile('photo_filename')) {
            // Check if an existing photo exists and delete it
            if ($newTheater->photo_filename && Storage::exists('public/photos/' . $newTheater->photo_filename)) {
                Storage::delete('public/photos/' . $newTheater->photo_filename);
            }

            // Store the new photo
            $path = $request->photo_filename->store('public/photos');
            $newTheater->photo_filename = basename($path);
            $newTheater->save();
        }

        $url = route('theaters.show', ['theater' => $newTheater]);
        $htmlMessage = "Theater <a href='$url'><u>{$newTheater->name}</u></a> has been created successfully!";
        return redirect()->route('theaters.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function edit(Theater $Theater): View
    {
        return view('theaters.edit')
            ->with('theater', $Theater);
    }

    public function update(TheaterFormRequest $request, Theater $theater): RedirectResponse
    {
        // Validate and update the theater's data
        $theater->update($request->validated());

        // Check if a new file is being uploaded
        if ($request->hasFile('photo_filename')) {
            // Check if an existing photo exists and delete it
            if ($theater->photo_filename && Storage::exists('public/photos/' . $theater->photo_filename)) {
                Storage::delete('public/photos/' . $theater->photo_filename);
            }

            // Store the new photo
            $path = $request->photo_filename->store('public/photos');
            $theater->photo_filename = basename($path);
            $theater->save();
        }

        // Redirect with a success message
        $url = route('theaters.show', ['theater' => $theater]);
        $htmlMessage = "Theater <a href='$url'><u>{$theater->name}</u></a> has been updated successfully!";
        return redirect()->route('theaters.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }


    public function destroy(Theater $theater): RedirectResponse
    {
        try {
            $url = route('theaters.show', ['theater' => $theater]);

            $totalCustomers = Customer::where('theater', $theater->abbreviation)->count();
            if ($totalCustomers == 0) {
                $theater->delete();
                $alertType = 'success';
                $alertMsg = "Theater {$theater->name} ({$theater->abbreviation}) has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $justification = match (true) {
                    $totalCustomers <= 0 => "",
                    $totalCustomers == 1 => "there is 1 Customer in the Theater",
                    $totalCustomers > 1 => "there are $totalCustomers Customers in the Theater",
                };
                $alertMsg = "Theater <a href='$url'><u>{$theater->name}</u></a> ({$theater->abbreviation}) cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the Theater
                            <a href='$url'><u>{$theater->name}</u></a> ({$theater->abbreviation})
                            because there was an error with the operation!";
        }
        return redirect()->route('Theaters.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
    public function destroyImage(Theater $theater): RedirectResponse
    {
        if ($theater->imageExists) {
            Storage::delete("public/photos/{$theater->photo_filename}");
        }
        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', "Photo of theater {$theater->name} has been deleted.");
    }

    public function show(Theater $theater): View
    {
        return view('theaters.show')->with('theater', $theater);
    }
}
