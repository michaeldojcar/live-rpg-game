<?php

namespace App\Http\Controllers;

use App\Player;
use App\Quest;
use App\QuestGroup;
use App\Role;
use App\User;
use Illuminate\Http\Request;

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
                'quest_count'         => Quest::where('parent_quest_id', '=', null)->count(),
                'sub_quest_count'     => Quest::where('parent_quest_id', '!=', null)->count(),
                'player_count'        => Player::count(),
                'role_count'          => Role::count(),
            ]
        );
    }
}
