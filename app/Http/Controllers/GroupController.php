<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\GroupStoreRequest;
use App\Http\Requests\GroupUpdateRequest;
use Illuminate\Http\Response;

class GroupController extends Controller
{
    public function index()
    {
        return Group::all();
    }

    public function show($id)
    {
        $group = $this->findById($id)->load(['players']);

        return response($group);
    }

    public function store(GroupStoreRequest $request)
    {
        $group       = new Group();
        $group->name = $request->input('name');
        $group->save();

        return response($group);
    }

    public function update($id, GroupUpdateRequest $request)
    {
        $group = $this->findById($id);

        $group->name = $request->input('name');
        $group->save();

        return response($group, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $group = $this->findById($id);

        $group->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    private function findById($id)
    {
        return Group::findOrFail($id);
    }
}
