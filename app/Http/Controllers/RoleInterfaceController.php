<?php

namespace App\Http\Controllers;

use App\Player;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * API for Role mobile interface.
 *
 * Class RoleInterfaceController
 * @package App\Http\Controllers
 */
class RoleInterfaceController extends Controller
{
    public function index($id)
    {
        return view('role', [
            'role' => Role::findOrFail($id)
        ]);
    }


    /**
     * Find user by color combination.
     *
     * @param $role_id int Opened role ID
     * @param $color_1
     * @param $color_2
     * @param $color_3
     *
     * @return string
     */
    public function show($role_id, $color_1, $color_2, $color_3)
    {
        // Find person
        $player = Player::findOrFail($role_id)
                        ->where('color_1', $color_1)
                        ->where('color_2', $color_2)
                        ->where('color_3', $color_3)
                        ->firstOrFail();

        // Find role
        $role = Role::findOrFail($role_id);

        // Available quests
        $quests_available = $player->availableQuestsForRole($role)->get();

        // If there is no available quest, try to find one
        if ( ! $quests_available)
        {
            $quests_available = $this->tryToAssignNewQuest($role, $player);
        }

        $resp = [
            'person'                  => $player,
            'quests_pending'          => $player->pendingQuestsForRole($role)->get(),
            'quests_available'        => $quests_available,
            'external_quests_pending' => $player->pendingSubQuestsForRole($role)->get(),
        ];

        return json_encode($resp);
    }

    /**
     * Save telemetry data of role. (last seen, coordinates)
     *
     * @param $id
     * @param  Request  $request
     *
     * @return array
     */
    public function telemetries($id, Request $request)
    {
//        dd($request);

        $role = Role::findOrFail($id);

        $role->latitude  = $request->input('latitude');
        $role->longitude = $request->input('longitude');
        $role->last_seen = Carbon::now();
        $role->save();

        return $request->toArray();
    }

    private function tryToAssignNewQuest(Role $role, Player $player): ?Collection
    {
        # TODO: Find all not done quests
        return $player->motherQuests()
                      ->wherePivot('status', 2)
                      ->where('quest_owner_id', $role->id)->get()->random();
    }
}
