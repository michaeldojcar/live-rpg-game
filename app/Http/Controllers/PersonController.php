<?php

namespace App\Http\Controllers;

use App\Person;
use App\Role;

class PersonController extends Controller
{
    public function show($role_id, $c1, $c2, $c3)
    {
        // Find person
        $person = Person::findOrFail($role_id)
            ->where('color_1', $c1)
            ->where('color_2', $c2)
            ->where('color_3', $c3)
            ->firstOrFail();

        // Find role
        $role = Role::findOrFail($role_id);

        $resp = [
            'user'                    => $person,
            'quests_pending'          => $person->pendingQuestsForRole($role)->get(),
            'quests_available'        => $person->availableQuestsForRole($role)->get(),
            'external_quests_pending' => $person->pendingSubQuestsForRole($role)->get(),
        ];

        return json_encode($resp);
    }
}
