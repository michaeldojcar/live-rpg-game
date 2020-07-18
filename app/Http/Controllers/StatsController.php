<?php

namespace App\Http\Controllers;

use App\Group;
use App\Player;
use App\Quest;

class StatsController extends Controller
{
    public function playerRank()
    {
        return Player::withCount(['doneQuests'])
                     ->get()
                     ->load(['group']);
    }

    public function groupRank()
    {
        return Group::all();
    }

    public function questsWithKnowledge()
    {
        return Quest::where('reward_knowledge', '!=', null)
            ->orderBy('quest_group_id')
            ->with('quest_group')
                    ->get()
            ->each->append(['spread']);
    }
}
