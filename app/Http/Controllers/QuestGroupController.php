<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestGroupStoreRequest;
use App\QuestGroup;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuestGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return QuestGroup[]|Collection
     */
    public function index()
    {
        return QuestGroup::withCount(['quests'])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  QuestGroupStoreRequest  $request
     *
     * @return Response
     */
    public function store(QuestGroupStoreRequest $request)
    {
        $quest_group         = new QuestGroup();
        $quest_group->name   = 'nová větev';
        $quest_group->active = false;
        $quest_group->save();

        return response($quest_group, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id)
    {
        $group = $this->findById($id);

        return response($group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     *
     * @return Application|ResponseFactory|Response
     */
    public function update(Request $request, $id)
    {
        $quest_group         = $this->findById($id);
        $quest_group->name   = $request->input('name');
        $quest_group->active = $request->input('active');
        $quest_group->save();

        return response($quest_group, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Application|ResponseFactory|Response
     * @throws Exception
     */
    public function destroy($id)
    {
        $quest_group = $this->findById($id);
        $quest_group->quests()->detach();
        $quest_group->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    private function findById(int $id): QuestGroup
    {
        return QuestGroup::findOrFail($id);
    }
}
