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

    public function questWithKnowledge()
    {
        return Quest::where('reward_knowledge', '!=', null)
                    ->get()->each->append(['spread']);
    }
}
