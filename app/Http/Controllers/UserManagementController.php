<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    // Menampilkan daftar user
    public function index()
    {
        $this->authorizeAdmin();
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // Form tambah user
    public function create()
    {
        $this->authorizeAdmin();
        return view('admin.users.create');
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    // Form edit user
    public function edit($id)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Update user (termasuk role)
    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($id);

        // Pengaman: Admin tidak boleh menurunkan role akunnya sendiri
        if ($user->id === auth()->id() && $request->role !== 'admin') {
            return back()->with('error', 'Anda tidak dapat menurunkan role akun Anda sendiri.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    // Hapus user dengan pengaman
    public function destroy($id)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($id);

        // Pengaman: Admin tidak boleh menghapus akunnya sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    private function authorizeAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    }
}