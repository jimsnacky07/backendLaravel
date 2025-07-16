<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:admin,id',
            'username' => 'required|unique:admin,username',
            'password' => 'required|min:6',
            'adminlevel' => 'required|integer',
        ]);

        $admin = new Admin();
        $admin->id = $request->id;
        $admin->username = $request->username;
        $admin->password = Hash::make($request->password);
        $admin->adminlevel = $request->adminlevel;
        $admin->save();

        return response()->json(['message' => 'Registration successful', 'admin' => $admin], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)->first();
        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $admin->createToken('admin-token')->plainTextToken;
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'admin' => $admin
        ]);
    }

    public function dashboard(Request $request)
    {
        return response()->json(['message' => 'Welcome to the dashboard', 'admin' => $request->user()]);
    }
}
