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
        $validatedData = $request->validated();

        $user = $request->user();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        // Verifica se o usuário já tem um customer associado
        $customer = $user->customer()->first();

        if (!$customer) {
            // Se não tiver, cria um novo customer com os dados validados
            $customer = $user->customer()->create([
                'nif' => $validatedData['nif'],
                'payment_type' => $validatedData['payment_type'],
                'payment_ref' => $validatedData['payment_ref'],
            ]);
        } else {
            // Se já tiver, atualiza os dados do customer
            $customer->nif = $validatedData['nif'];
            $customer->payment_type = $validatedData['payment_type'];
            $customer->payment_ref = $validatedData['payment_ref'];
            $customer->save(); // Salva as alterações no customer
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save(); // Salva as alterações no user

        $url = route('profile.edit');
        $htmlMessage = "Profile <a href='$url'><u>{$user->name}</u></a> has been updated successfully!";
        return redirect()->route('profile.edit')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
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
