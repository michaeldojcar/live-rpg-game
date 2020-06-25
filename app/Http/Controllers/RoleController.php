<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function show($id)
    {
        return Role::findOrFail($id)->append(['is_online']);
    }

    public function index()
    {
        return Role::withCount(['quests'])->get()->values();
    }

    /**
     * Roles for OSM map view.
     *
     * @return string
     */
    public function mapIndex()
    {
        $roles = Role::all()->map(function ($role)
        {
            $role->latlong = [$role->latitude, $role->longitude];

            return $role;
        });

        $roles = $roles->filter(function (Role $role)
        {


            $valid_coords = $role->latitude && $role->longitude;

            return $valid_coords && $role->getIsOnlineAttribute();
        });

        return $roles->values();
    }

    public function store(Request $request)
    {
        $role                    = new Role();
        $role->name              = $request->input('name');
        $role->real_name         = $request->input('real_name');
        $role->story             = null;
        $role->action_recommends = null;
        $role->place_recommends  = null;
        $role->save();

        return $role;
    }

    public function update(Role $role, Request $request)
    {
        $role->fill($request->toArray());
        $role->save();

        return $role;
    }
}
