<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $admin = Admin::all();
        $admin = $admin->map(function ($a) {
            $a->foto = $a->foto ? asset('storage/' . $a->foto) : null;
            return $a;
        });
        return response()->json($admin);
    }

    public function show($id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $admin->foto = $admin->foto ? asset('storage/' . $admin->foto) : null;
        return response()->json($admin);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string|max:30|unique:admin,id',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'adminlevel' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,svg',
        ]);
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_admin', 'public');
            $validated['foto'] = $fotoPath;
        }
        $validated['password'] = Hash::make($validated['password']);
        $admin = Admin::create($validated);
        return response()->json($admin, 201);
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $validated = $request->validate([
            'id' => 'sometimes|required|string|max:30|unique:admin,id',
            'username' => 'sometimes|required|string|max:255',
            'password' => 'nullable|string|min:6',
            'adminlevel' => 'sometimes|required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,svg',
        ]);
        if ($request->hasFile('foto')) {
            if ($admin->foto) {
                Storage::disk('public')->delete($admin->foto);
            }
            $fotoPath = $request->file('foto')->store('foto_admin', 'public');
            $validated['foto'] = $fotoPath;
        }
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        $admin->update($validated);
        return response()->json($admin);
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $admin->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
