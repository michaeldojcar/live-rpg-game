<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    public function show($id)
    {
        return Role::findOrFail($id)
                   ->append(['is_online', 'last_seen_string'])
                   ->load(['quests']);
    }

    public function index()
    {
        return Role::withCount(['quests'])->get()->values();
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

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        $role->quests()->delete();

        $role->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }
}
