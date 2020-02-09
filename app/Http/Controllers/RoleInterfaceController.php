<?php

namespace App\Http\Controllers;

use App\Player;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RoleInterfaceController extends Controller
{
    /**
     * Find user by color combination.
     *
     * @param $role_id int Opened role ID
     * @param $color_1
     * @param $color_2
     * @param $color_3
     * @return string
     */
    public function show($role_id, $color_1, $color_2, $color_3)
    {
        // Find person
        $person = Player::findOrFail($role_id)
            ->where('color_1', $color_1)
            ->where('color_2', $color_2)
            ->where('color_3', $color_3)
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

    /**
     * Save telemetry data of role. (last seen, coordinates)
     *
     * @param $id
     * @param Request $request
     * @return array
     */
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
