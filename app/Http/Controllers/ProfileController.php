<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

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

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validated();

        // tratar upload de avatar separadamente (redimensionar e otimizar)
        if ($request->hasFile('avatar')) {
            // remover avatar antigo se existir
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $uploaded = $request->file('avatar');
            // gerar nome único e forçar jpg
            $filename = 'avatars/' . $user->id . '_' . time() . '.jpg';

            // tentar usar Intervention Image para redimensionar e otimizar
            try {
                $img = Image::make($uploaded->getPathname())
                    ->fit(200, 200)
                    ->encode('jpg', 80);

                Storage::disk('public')->put($filename, (string) $img);
                $data['avatar'] = $filename;
            } catch (\Throwable $e) {
                // se houver qualquer falha (ex.: driver GD/Imagick ausente), fallback para salvar o arquivo original
                // registrar o erro para debug
                \Illuminate\Support\Facades\Log::error('Avatar processing failed: ' . $e->getMessage());

                $path = $uploaded->store('avatars', 'public');
                $data['avatar'] = $path;
            }
        }

        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

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

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
