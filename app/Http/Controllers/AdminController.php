<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        return view('admin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'adminlevel' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,svg',
        ]);
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto', 'public');
            $validated['foto'] = $fotoPath;
        }
        $validated['password'] = Hash::make($validated['password']);
        $admin = Admin::create($validated);
        return redirect()->route('admin.index')->with('success', 'Admin berhasil ditambahkan');
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $validated = $request->validate([
            'username' => 'sometimes|required|string|max:255',
            'password' => 'nullable|string|min:6',
            'adminlevel' => 'sometimes|required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,svg',
        ]);
        if ($request->hasFile('foto')) {
            if ($admin->foto) {
                Storage::disk('public')->delete($admin->foto);
            }
            $fotoPath = $request->file('foto')->store('foto', 'public');
            $validated['foto'] = $fotoPath;
        }
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        $admin->update($validated);
        return redirect()->route('admin.index')->with('success', 'Admin berhasil diupdate');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect()->route('admin.index')->with('success', 'Admin berhasil dihapus');
    }

    // Login endpoint tetap ada untuk API
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $admin = Admin::where('username', $credentials['username'])->first();
        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            return response()->json(['message' => 'Login berhasil', 'admin' => $admin]);
        }
        return response()->json(['message' => 'Username atau password salah'], 401);
    }
}
