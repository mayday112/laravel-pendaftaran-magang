<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', ['user' => $request->user(), 'type_menu' => '']);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    // public function update(Request $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        // dd($request);
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        if ($request->file('photo_profile')) {
            // return 'oke';
            // dd($request->file('photo_profile'));
            if (Storage::disk('public')->exists("foto profil/{$request->user()->photo_path}")) {
                Storage::disk('public')->delete("foto profil/{$request->user()->photo_path}");
            }

            $file = $request->file('photo_profile');
            $fotoName = Str::slug($request->user()->name . '-' . Str::random(5)) . $request->file('photo_profile')->hashName();
            $file->storeAs('foto profil', $fotoName, 'public');

            $request->user()->photo_path = $fotoName;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
        // hapus foto profil jika ada
        if ($user->photo_path) {
            Storage::disk('public')->delete("foto profil/{$user->photo_path}");
        }
        // hapus file-file magang jika ada
        if ($user->internship) {
            Storage::disk('public')->delete("surat pengantar/{$user->internship->surat_pengantar}");

            if (Storage::disk('public')->exists("nilai magang/{$user->internship->nilai_magang}")) {
                Storage::disk('public')->delete("nilai magang/{$user->internship->nilai_magang}");
            }
        }
        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
