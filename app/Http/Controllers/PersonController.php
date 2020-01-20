<?php

namespace App\Http\Controllers;

use App\Person;
use App\Role;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function show($role_id, $person_id)
    {
        $person = Person::findOrFail($role_id);
        $role = Role::findOrFail($role_id);

        $resp = [
            'user' => $person,
            'quests_pending' => $person->pendingQuestsForRole($role)->get(),
            'quests_available' => $person->availableQuestsForRole($role)->get(),
            'external_quests_pending' => $person->pendingSubQuestsForRole($role)->get(),
        ];

        return json_encode($resp);
    }
}
