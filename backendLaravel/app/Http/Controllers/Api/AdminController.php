<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return response()->json(Admin::all());
    }

    public function show($id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($admin);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            // tambahkan validasi field lain sesuai kebutuhan
        ]);
        $admin = Admin::create($data);
        return response()->json($admin, 201);
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $data = $request->all();
        $admin->update($data);
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
