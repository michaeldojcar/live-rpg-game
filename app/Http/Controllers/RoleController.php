<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function show($id)
    {
        return view('role', [
            'role' => Role::findOrFail($id)
        ]);
    }

    public function index()
    {
        $roles = Role::all()->map(function ($role) {
            $role->latlong = [$role->latitude, $role->longitude];
            return $role;
        });

        return $roles->filter(function ($role) {
            return $role->latitude && $role->longitude;
        });
    }
}
