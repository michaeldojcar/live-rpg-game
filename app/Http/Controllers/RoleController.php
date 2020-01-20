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
}
