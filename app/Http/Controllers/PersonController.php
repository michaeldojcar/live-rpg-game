<?php

namespace App\Http\Controllers;

use App\Person;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
            'person' => $person,
            'quests_pending' => $person->pendingQuestsForRole($role)->get(),
            'quests_available' => $person->availableQuestsForRole($role)->get(),
            'external_quests_pending' => $person->pendingSubQuestsForRole($role)->get(),
        ];

        return json_encode($resp);
    }

    public function telemetries($id, Request $request)
    {
//        dd($request);

        $role = Role::findOrFail($id);

        $role->latitude = $request->input('latitude');
        $role->longitude = $request->input('longitude');
        $role->last_seen = Carbon::now();
        $role->save();

        return $request->toArray();
    }
}
