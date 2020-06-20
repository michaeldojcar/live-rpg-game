<?php

namespace App\Http\Controllers;

use App\Option;
use App\Player;
use App\PlayerQuest;
use App\Quest;
use App\Repositories\LogRepository;
use App\Role;
use Illuminate\Database\Eloquent\Model;
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
        $player = Player::where('color_1', $color_1)
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
            $this->tryToAssignNewQuest($role, $player);
            $role_pending_quests = $player->pendingQuestsForRole($role);
        }

        $resp = [
            'person'                  => $player,
            'quests_pending'          => $role_pending_quests->get(),
            'external_quests_pending' => $player->pendingSubQuestsForRole($role)->get(),
        ];

        // Log player logged
        $lr = new LogRepository();
        $lr->playerLogged($player, $role);

        $player->refreshLastSeen();

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
        $role = Role::findOrFail($id);

        $role->latitude  = $request->input('latitude');
        $role->longitude = $request->input('longitude');
        $role->last_seen = Carbon::now();
        $role->save();

        return [
            'latitude'      => $request->input('latitude'),
            'longitude'     => $request->input('longitude'),
            'admin_message' => Option::getValue('admin_message')
        ];
    }

    /**
     * @param  Role  $role
     * @param  Player|Model  $player
     *
     * @return Quest|null
     */
    public function tryToAssignNewQuest(Role $role, Player $player): ?Quest
    {
        // Find suitable quests.
        $player_age = $player->getAgeAttribute();

        // Filter
        $quests = Quest::where('parent_quest_id', '=', null)
                       ->where('quest_owner_id', $role->id) // Owner of quest is selected role
                       ->where('age_from', '<=', $player_age)
                       ->where('age_to', '>=', $player_age)
                       ->get();

        // Filter only quests that user never played
        $quests = $this->filterOnlyNewQuestsForUser($quests, $player);

        if ( ! $quests->count())
        {
            return null;
        }

        // Get random quest from suitable quests.
        $quest = $quests->random();

        // Set quest status to pending for selected player.
        $player->quests()->attach($quest, ['status' => PlayerQuest::STATUS_AVAILABLE]);

        return $quest;
    }

    private function filterOnlyNewQuestsForUser($quests, $player)
    {
        return $quests->filter(function (Quest $quest) use ($player)
        {
            /** @var Quest $quest_with_pivot */
            $quest_with_pivot = $player->quests()->withPivot('status')->find($quest);

            if ( ! $quest_with_pivot)
            {
                return true;
            }

            $status = $quest_with_pivot->pivot->status;

            if ($status == PlayerQuest::STATUS_PENDING || $status == PlayerQuest::STATUS_FAILED || $status == PlayerQuest::STATUS_DONE)
            {
                return false;
            }

            return true;
        });
    }

    public function setPending(Role $role, Quest $quest)
    {
        /* @var \App\PlayerQuest */
        $quest_record = PlayerQuest::where('role_id', $role->id)->where('quest_id', $quest->id)->firstOrFail();

        if ($quest_record->status == PlayerQuest::STATUS_AVAILABLE)
        {
            $quest_record->status = PlayerQuest::STATUS_PENDING;
            $quest_record->save();

            return response(201, $quest_record);
        }

        return response(412, 'Quest must be set as available.');
    }

    public function setDone(Role $role, Quest $quest)
    {
        /* @var \App\PlayerQuest */
        $quest_record = PlayerQuest::where('role_id', $role->id)->where('quest_id', $quest->id)->firstOrFail();

        if ($quest_record->status == PlayerQuest::STATUS_PENDING)
        {
            $quest_record->status = PlayerQuest::STATUS_DONE;
            $quest_record->save();

            return response(201, $quest_record);
        }

        return response(412, 'Quest must be set as pending.');
    }

    public function setFailed(Role $role, Quest $quest)
    {
        /* @var \App\PlayerQuest */
        $quest_record = PlayerQuest::where('role_id', $role->id)->where('quest_id', $quest->id)->firstOrFail();

        if ($quest_record->status == PlayerQuest::STATUS_PENDING)
        {
            $quest_record->status = PlayerQuest::STATUS_FAILED;
            $quest_record->save();

            return response(201, $quest_record);
        }

        return response(412, 'Quest must be set as available.');
    }
}
