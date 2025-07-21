<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Penghuni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('penghuni')->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $penghuniList = Penghuni::whereNull('user_id')->get();
        return view('user.create', compact('penghuniList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'penghuni_id' => 'nullable|exists:penghuni,id',
            'tanggal_bayar' => 'nullable|date',
            'role' => 'required|string',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        if (!empty($validated['penghuni_id'])) {
            $penghuni = Penghuni::find($validated['penghuni_id']);
            $penghuni->user_id = $user->id;
            if (!empty($validated['tanggal_bayar'])) {
                $penghuni->tanggal_bayar = $validated['tanggal_bayar'];
            }
            $penghuni->save();
        }

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function show($id)
    {
        $user = User::with('penghuni')->findOrFail($id);
        return view('user.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::with('penghuni')->findOrFail($id);
        $penghuniList = Penghuni::where(function ($q) use ($user) {
            $q->whereNull('user_id')->orWhere('user_id', $user->id);
        })->get();
        return view('user.edit', compact('user', 'penghuniList'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => ['sometimes', 'required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'penghuni_id' => 'nullable|exists:penghuni,id',
            'tanggal_bayar' => 'nullable|date',
            'role' => 'required|string',
        ]);

        if (isset($validated['name'])) $user->name = $validated['name'];
        if (isset($validated['email'])) $user->email = $validated['email'];
        if (!empty($validated['password'])) $user->password = Hash::make($validated['password']);
        if (isset($validated['role'])) $user->role = $validated['role'];
        $user->save();

        // Update relasi penghuni
        if (array_key_exists('penghuni_id', $validated)) {
            // Unlink penghuni lama
            if ($user->penghuni) {
                $user->penghuni->user_id = null;
                $user->penghuni->save();
            }
            // Link penghuni baru
            if ($validated['penghuni_id']) {
                $penghuni = Penghuni::find($validated['penghuni_id']);
                $penghuni->user_id = $user->id;
                if (!empty($validated['tanggal_bayar'])) {
                    $penghuni->tanggal_bayar = $validated['tanggal_bayar'];
                }
                $penghuni->save();
            }
        } elseif ($user->penghuni && !empty($validated['tanggal_bayar'])) {
            // Jika hanya update tanggal_bayar pada penghuni yang sudah terhubung
            $user->penghuni->tanggal_bayar = $validated['tanggal_bayar'];
            $user->penghuni->save();
        }

        return redirect()->route('user.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->penghuni) {
            $user->penghuni->user_id = null;
            $user->penghuni->save();
        }
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }
}
