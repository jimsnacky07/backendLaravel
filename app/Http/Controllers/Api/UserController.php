<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Penghuni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Tampilkan semua user beserta penghuni terkait
    public function index()
    {
        $users = User::with('penghuni')->get();
        return response()->json($users);
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'penghuni_id' => 'nullable|exists:penghuni,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Relasikan ke penghuni jika ada
        if (!empty($validated['penghuni_id'])) {
            $penghuni = Penghuni::find($validated['penghuni_id']);
            $penghuni->user_id = $user->id;
            $penghuni->save();
        }

        return response()->json($user->load('penghuni'), 201);
    }

    // Tampilkan detail user
    public function show($id)
    {
        $user = User::with('penghuni')->findOrFail($id);
        return response()->json($user);
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => ['sometimes', 'required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'penghuni_id' => 'nullable|exists:penghuni,id',
        ]);

        if (isset($validated['name'])) $user->name = $validated['name'];
        if (isset($validated['email'])) $user->email = $validated['email'];
        if (!empty($validated['password'])) $user->password = Hash::make($validated['password']);
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
                $penghuni->save();
            }
        }

        return response()->json($user->load('penghuni'));
    }

    // Hapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // Unlink penghuni jika ada
        if ($user->penghuni) {
            $user->penghuni->user_id = null;
            $user->penghuni->save();
        }
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('user-token')->plainTextToken;
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);
    }
}
