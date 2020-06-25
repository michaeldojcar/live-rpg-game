<?php

namespace App\Http\Controllers;

use App\Quest;

class StatsController extends Controller
{
    public function playerRank()
    {

    }

    public function groupRank()
    {

    }

    public function questWithKnowledge()
    {
        return Quest::where('reward_knowledge', '!=', null)
                    ->get()->each->append(['spread']);
    }
}
