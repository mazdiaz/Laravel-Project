<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = User::query()->orderByDesc('id');

        if ($request->filled('search')) {
            $s = $request->string('search');
            $q->where(function ($x) use ($s) {
                $x->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%");
            });
        }

        if ($request->filled('role')) {
            $q->where('role', $request->string('role'));
        }

        if ($request->filled('active')) {
            $q->where('is_active', (int)$request->input('active') === 1);
        }

        $users = $q->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    // Menampilkan Form Tambah User Baru
    public function create()
    {
        return view('admin.users.create');
    }

    // Menyimpan User Baru ke Database
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'], 
            'role'     => ['required', 'in:customer,seller,admin'],
            'is_active'=> ['required', 'boolean'],
        ]);

        // Enkripsi password sebelum disimpan
        $data['password'] = Hash::make($data['password']);
        
        // Opsional: Langsung verifikasi email agar seller bisa langsung login
        $data['email_verified_at'] = now(); 

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'role'      => ['required', 'in:customer,seller,admin'],
            'is_active' => ['required', 'boolean'],
        ]);

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    // Menghapus User
    public function destroy(User $user)
    {
        // Mencegah admin menghapus dirinya sendiri yang sedang login
        if ($user->id === auth()->id()) {
            return back()->withErrors(['Tidak bisa menghapus akun sendiri.']);
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }
}