<?php

namespace App\Http\Controllers;

use App\Quest;
use App\Role;
use Illuminate\Http\Request;

class QuestController extends Controller
{
    public function index()
    {
        return Quest::with(['owner'])->where('parent_quest_id', null)->get();
    }

    public function store(Request $request)
    {
        $quest                          = new Quest();
        $quest->name                    = 'nový quest';
        $quest->description             = 'doplnit';
        $quest->is_mother               = true;
        $quest->unlock_criteria         = 1;
        $quest->allow_more_attempts     = true;
        $quest->allow_finish_repeatedly = false;
        $quest->quest_owner_id          = Role::first()->id;
        $quest->is_reward_public        = false;
        $quest->is_dumb                 = false;
        $quest->save();

        return $quest;
    }

    public function edit($id)
    {
        return [
            'quest' => Quest::findOrFail($id)->append(['chain_quests']),
            'roles' => Role::all(),
        ];
    }

    public function update(Quest $quest, Request $request)
    {
        $quest->fill($request->except(['chain_quests', 'parent_quest','id']));
        $quest->save();

        return $quest;
    }
}
