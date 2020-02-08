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

    /**
     * Roles for map.
     *
     * @return string
     */
    public function mapIndex()
    {
        $roles = Role::all()->map(function ($role) {
            $role->latlong = [$role->latitude, $role->longitude];
            return $role;
        });

        $roles = $roles->filter(function (Role $role) {


            $valid_coords = $role->latitude && $role->longitude;

            return $valid_coords && $role->isOnline();
        });

        return $roles->toJson();
    }
}
