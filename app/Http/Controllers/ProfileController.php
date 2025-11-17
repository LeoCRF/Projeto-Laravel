<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Models\Recipe;

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = Auth::user();

        return view('profile.profile', [
            'user' => $user,
            'myRecipes' => $user->recipes()->latest()->get(),
            'likedRecipes' => $user->likes()->latest()->get(),
            'savedRecipes' => $user->saved_recipes()->latest()->get(),
        ]);
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        // Avatar upload
        if ($request->hasFile('avatar')) {

            // Delete old avatar
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $file = $request->file('avatar');
            $filename = "avatars/{$user->id}_" . time() . ".jpg";

            try {
                $image = Image::make($file->getPathname())
                    ->resize(600, null, function ($c) {
                        $c->aspectRatio();
                        $c->upsize();
                    })
                    ->fit(200, 200)
                    ->encode('jpg', 80);

                Storage::disk('public')->put($filename, (string)$image);

                $data['avatar'] = $filename;

            } catch (\Throwable $e) {
                Log::error("Avatar processing failed: {$e->getMessage()}");

                $data['avatar'] = $file->store('avatars', 'public');
            }
        }

        // Update
        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request)
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
