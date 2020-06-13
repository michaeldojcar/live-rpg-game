<?php

namespace App\Http\Controllers;

use App\Log;
use App\Player;
use App\PlayerQuest;
use App\Quest;
use App\QuestGroup;
use App\Role;
use Carbon\Carbon;

class OperatorController extends Controller
{
    public function index()
    {
        return view('operator');
    }

    public function overview()
    {
        return response(
            [
                'active_quest_groups' => QuestGroup::whereActive(true)->get(),

                'quests_count'           => Quest::count(),
                'pending_quests_count'   => $this->getPendingQuestsCount(),
                'today_completed_quests' => $this->getTodayCompletedQuests(),

                'players_count'        => Player::count(),
                'players_online_count' => $this->getPlayersOnline(),

                'roles_count'        => Role::count(),
                'roles_online_count' => $this->getRolesOnline(),

                'latest_logs' => Log::latest()->limit(10)->get()->load(['player', 'role', 'quest']),
            ]
        );
    }

    private function getPlayersOnline()
    {
        return Player::where('last_seen', '>=', Carbon::now()->subSeconds(240))->count();
    }

    private function getRolesOnline()
    {
        return Role::where('last_seen', '>=', Carbon::now()->subSeconds(25))->count();
    }

    private function getPendingQuestsCount()
    {
        return PlayerQuest::where('status', Quest::STATUS_PENDING)->count();
    }

    private function getTodayCompletedQuests()
    {
        return PlayerQuest::where('status', Quest::STATUS_DONE)
                          ->whereDate('created_at', Carbon::today())
                          ->count();
    }


}
