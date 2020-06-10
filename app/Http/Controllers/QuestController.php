<?php

namespace App\Http\Controllers;

use App\Quest;
use App\QuestGroup;
use App\Role;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
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
        $quest->name                    = 'nový úkol';
        $quest->description             = 'doplnit';
        $quest->unlock_criteria         = 1;
        $quest->allow_more_attempts     = true;
        $quest->allow_finish_repeatedly = false;
        $quest->quest_owner_id          = Role::first()->id;
        $quest->is_reward_public        = false;
        $quest->is_dumb                 = false;
        $quest->quest_group_id          = 1;
        $quest->save();

        return $quest;
    }

    /**
     * Create sub-quest after last sub-quest or quest.
     *
     * @param $existing_quest_id
     * @param  Request  $request
     *
     * @return Quest
     */
    public function storeSubQuest($existing_quest_id, Request $request)
    {
        $selected_quest = Quest::findOrFail($existing_quest_id);
        $parent         = $selected_quest->getLastSubQuest();

        // Create sub-quest
        $sub_quest                          = new Quest();
        $sub_quest->name                    = 'podúkol';
        $sub_quest->description             = 'doplnit';
        $sub_quest->unlock_criteria         = 1;
        $sub_quest->allow_more_attempts     = true;
        $sub_quest->allow_finish_repeatedly = false;
        $sub_quest->quest_owner_id          = Role::first()->id;
        $sub_quest->is_reward_public        = false;
        $sub_quest->is_dumb                 = false;
        $sub_quest->quest_group_id          = $parent->quest_group_id;
        $sub_quest->parent_quest_id         = $parent->id;
        $sub_quest->save();

        return $sub_quest;
    }

    public function edit($id)
    {
        return [
            'quest'        => Quest::findOrFail($id)->append(['chain_quests']),
            'roles'        => Role::all(),
            'quest_groups' => QuestGroup::all(),
        ];
    }

    public function update(Quest $quest, Request $request)
    {
        $quest->fill($request->except(['chain_quests', 'parent_quest', 'id']));
        $quest->save();

        return $quest;
    }

    /**
     * Destroy sub-quest.
     *
     * @param $id
     *
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     * @throws Exception
     */
    public function destroy($id)
    {
        $quest = Quest::findOrFail($id);

        if ($quest->sub_quest)
        {
            $quest->sub_quest->parent_quest_id = $quest->parent_quest_id;
            $quest->sub_quest->save();
        }

        $quest->delete();

        $response = ['parent_quest_id' => $quest->parent_quest_id];

        return response($response, 200);
    }
}
