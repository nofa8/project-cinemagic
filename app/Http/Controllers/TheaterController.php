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
        // Check for future screenings
        $futureScreenings = $theater->screenings()->where('date', '>', now())->count();

        if ($futureScreenings > 0) {
            $htmlMessage = "Theater \"{$theater->name}\" cannot be deleted because it has future screenings scheduled.";
            return redirect()->route('theaters.index')
                ->with('alert-type', 'error')
                ->with('alert-msg', $htmlMessage);
        }
<<<<<<< HEAD

        // Delete the associated photo if it exists
        // if ($theater->photo_filename && Storage::exists('public/photos/' . $theater->photo_filename)) {
        //     Storage::delete('public/photos/' . $theater->photo_filename);
        // }

        // Delete the theater from the database
        $theater->delete();

        // Redirect with a success message
        $htmlMessage = "Theater \"{$theater->name}\" has been deleted successfully!";
        return redirect()->route('theaters.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
=======
        return redirect()->route('theaters.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
>>>>>>> 2d2b479c66da3c2271ecefa90e898ec3b334e0f2
    }

    public function deleted(){
        $theaters = Theater::onlyTrashed()->orderBy('name')->paginate(14)->withQueryString();
        return view('theaters.deleted')->with('theaters', $theaters);
    }

    public function save(Theater $theater): RedirectResponse{
        dump($theater);
        if (!$theater->trashed()){
            return view('theaters.deleted');    
        }
        $theater->restore();
        return redirect()->back()->with('alert-type', 'success')
        ->with('alert-msg', "Theater \"{$theater->name}\" has been restored.");;
    }

    public function destruction(Theater $theater): RedirectResponse{
        if ($theater->trashed()){
            return redirect()->route('theaters.index')
                ->with('alert-type', 'error')
                ->with('alert-msg', "Theater \"{$theater->name}\" is not in the deleted list.");
        }
        if ($theater->photo_filename && Storage::exists('public/photos/' . $theater->photo_filename)) {
            Storage::delete('public/photos/' . $theater->photo_filename);
        }
        $name = $theater->name;
        $theater->forceDelete();
        dd($theater);
        return redirect()->route('theaters.deleted')
            ->with('alert-type', 'success')
            ->with('alert-msg', "Theater \"{$name}\" has been permanently deleted.");
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
