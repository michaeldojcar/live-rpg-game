<?php

namespace App\Http\Controllers;

use App\Option;
use App\Player;
use App\PlayerQuest;
use App\Quest;
use App\Repositories\LogRepository;
use App\Repositories\PlayerQuestRepository;
use App\Repositories\PlayerRepository;
use App\Role;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

/**
 * API for Role mobile interface.
 *
 * Class RoleInterfaceController
 * @package App\Http\Controllers
 */
class RoleInterfaceController extends Controller
{
    /**
     * @var PlayerQuestRepository
     */
    private $player_quest_repository;

    /**
     * @var PlayerRepository
     */
    private $player_repository;

    public function __construct()
    {
        $this->player_quest_repository = new PlayerQuestRepository();
        $this->player_repository       = new PlayerRepository();
    }

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
        // Find player
        $player = Player::where('color_1', $color_1)
                        ->where('color_2', $color_2)
                        ->where('color_3', $color_3)
                        ->firstOrFail();

        // Find role
        $role = Role::findOrFail($role_id);

        $player->refreshLastSeen();
        $player->refreshLocationAtRole($role);

        // Log player logged at the person
        $lr = new LogRepository();
        $lr->playerLogged($player, $role);

        $response = $this->getPlayerQuestsForRole($player, $role);

        return json_encode($response);
    }

    /**
     * @param $role_id
     * @param $player_id
     *
     * @return Application|ResponseFactory|Response
     */
    public function showById($role_id, $player_id)
    {
        // Find player
        $player = Player::findOrFail($player_id);

        $player->refreshLastSeen();

        // Find role
        $role = Role::findOrFail($role_id);

        $response = $this->getPlayerQuestsForRole($player, $role);

        return response($response);
    }

    /**
     * Get player quests for this role.
     *
     * If there is no available quest for the role,
     * try to assign new one available.
     *
     * @param  Player|Model  $player
     * @param  Role|Model  $role
     *
     * @return array
     */
    private function getPlayerQuestsForRole(Player $player, Role $role): array
    {
        // Pending quests
        $role_pending_quests = $player->pendingQuestsForRole($role);

        // If there is no available quest, try to assign new one
        if ( ! $role_pending_quests->count())
        {
            $this->tryToAssignNewQuest($role, $player);
            $role_pending_quests = $player->pendingQuestsForRole($role);
        }

        // Response array
        return [
            'person'                  => $player,
            'quests_pending'          => $role_pending_quests->get()->each->append(['parent_role', 'subquest_role']),
            'external_quests_pending' => $player->pendingSubQuestsForRole($role)->get()->each->append([
                'parent_role', 'subquest_role'
            ]),
        ];
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
                       ->where('quest_group_id', '=', 1)
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

    public function setPending($player_id, $quest_id)
    {
        $player = Player::findOrFail($player_id);
        $quest  = Quest::findOrFail($quest_id);

        /* @var PlayerQuest */
        $quest_record = $this->player_quest_repository->getQuestState($quest, $player);

        // Validate current quest state
        if ($quest_record->status != PlayerQuest::STATUS_AVAILABLE)
        {
            return response('Quest must be set as available.', Response::HTTP_PRECONDITION_FAILED);
        }

        // Set quest pending
        $this->player_quest_repository->setUserQuestState($quest, $player, PlayerQuest::STATUS_PENDING);

        // If there is related sub-quest, make it available
        if ($quest->sub_quest)
        {
            $this->player_quest_repository->setUserQuestState($quest->sub_quest, $player,
                PlayerQuest::STATUS_AVAILABLE);
        }

        return response($quest_record, Response::HTTP_OK);
    }

    public function setDone($player_id, $quest_id)
    {
        $player = Player::findOrFail($player_id);
        $quest  = Quest::findOrFail($quest_id);

        /* @var PlayerQuest */
        $quest_record = $this->player_quest_repository->getQuestState($quest, $player);

        if ($quest_record->status == PlayerQuest::STATUS_PENDING)
        {
            $this->player_quest_repository->setQuestWithAllChildsDone($quest, $player);

            // Give rewards to player
            $this->player_repository->addQuestRewardsToPlayer($player, $quest);

            return response($quest_record, Response::HTTP_OK);
        }

        return response('Quest must be set as pending.', Response::HTTP_PRECONDITION_FAILED);
    }

    public function setFailed($player_id, $quest_id)
    {
        $player = Player::findOrFail($player_id);
        $quest  = Quest::findOrFail($quest_id);

        /* @var PlayerQuest */
        $quest_record = $this->player_quest_repository->getQuestState($quest, $player);

        if ($quest_record->status == PlayerQuest::STATUS_PENDING)
        {
            $this->player_quest_repository->setQuestWithAllChildsFailed($quest, $player);

            return response($quest_record, Response::HTTP_OK);
        }

        return response('Quest must be set as pending.', Response::HTTP_PRECONDITION_FAILED);
    }

    /**
     * Reset quests for role and player.
     *
     * @param $role_id
     * @param $player_id
     */
    public function resetQuests($player_id, $role_id)
    {
        // Reset pending quests
        $player = Player::findOrFail($player_id);
        $role   = Role::findOrFail($role_id);

        $pending_quests = $player->pendingQuestsForRole($role)->get();

        foreach ($pending_quests as $quest)
        {
            /* @var $quest Quest */
            $player->quests()->detach($quest);
        }

        // Assign new quest
        $this->tryToAssignNewQuest($role, $player);
    }
}
