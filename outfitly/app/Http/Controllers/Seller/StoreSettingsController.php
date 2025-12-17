<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class StoreSettingsController extends Controller
{
    public function edit(Request $request)
    {
        return view('seller.settings.index', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'phone'   => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:500'],
            'photo'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = $request->user();

        if ($request->hasFile('photo')) {
            // delete old avatar if any
            if (!empty($user->avatar_path)) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            // store new avatar
            $path = $request->file('photo')->store('avatars', 'public');
            $user->avatar_path = $path;
        }

        $user->name = $data['name'];
        $user->phone = $data['phone'] ?? null;
        $user->address = $data['address'] ?? null;

        $user->save();

        return back()->with('success', 'Pengaturan toko berhasil diperbarui.');
    }
}
