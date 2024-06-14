<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function editPassword(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateImage(ProfileUpdateRequest $request): RedirectResponse
    {

        if (empty($request->photo_filename)){
            return Redirect::route('profile.edit');
        }
        if ($request->user()->photo_filename && Storage::fileExists('public/photos/' . $request->user()->photo_filename)) {
            Storage::delete('public/photos/' . $request->user()->photo_filename);
        }
        $path = $request->photo_filename->store('public/photos');
        $request->user()->photo_filename = basename($path);
        $request->user()->save();


        return Redirect::route('profile.edit')->with('status', 'profile-updated');

    }

    public function destroyImage(User $user): RedirectResponse
    {
        if ($user->photo_filename && Storage::fileExists('public/photos/' . $user->photo_filename)) {
            Storage::delete("public/photos/{$user->photo_filename}");
        }

        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', "Photo of user {$user->name} has been deleted.");
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
