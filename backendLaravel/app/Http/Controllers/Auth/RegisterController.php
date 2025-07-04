<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

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

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }
}
