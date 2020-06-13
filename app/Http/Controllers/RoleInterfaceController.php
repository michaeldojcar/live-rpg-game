<?php

namespace App\Http\Controllers;

use App\Player;
use App\Quest;
use App\Repositories\LogRepository;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

        // Pending quest
        $role_pending_quests = $player->pendingQuestsForRole($role);

        // If there is no available quest, try to find one
        if ( ! $role_pending_quests->count())
        {
            $new_selected_quest  = $this->tryToAssignNewQuest($role, $player);
            $role_pending_quests = collect($new_selected_quest);
        }

        $resp = [
            'person'                  => $player,
            'quests_pending'          => $role_pending_quests,
            'external_quests_pending' => $player->pendingSubQuestsForRole($role)->get(),
        ];

        // Log player logged
        $lr = new LogRepository();
        $lr->playerLogged($player, $role);

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

    /**
     * @param  Role  $role
     * @param  Player  $player
     *
     * @return Quest|null
     */
    private function tryToAssignNewQuest(Role $role, Player $player): ?Quest
    {
        // Find suitable quests.
        $player_age = $player->getAgeAttribute();

        $quests = $player->motherQuests()
                         ->where('quest_owner_id', $role->id) // Owner of quest is selected role
                         ->where('age_from', '<=', $player_age)
                         ->where('age_to', '>=', $player_age)
                         ->wherePivot('status', '!=', Quest::STATUS_PENDING)
                         ->wherePivot('status', '!=', Quest::STATUS_FAILED)
                         ->wherePivot('status', '!=', Quest::STATUS_DONE)
                         ->get();

        if ( ! $quests->count())
        {
            return null;
        }

        // Get random quest from suitable quests.
        $quest = $quests->random();

        // Set quest status to pending for selected player.
        $quest->pivot->status = Quest::STATUS_PENDING;
        $quest->pivot->save();


        return $quest;
    }
}
