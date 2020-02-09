<?php

namespace App\Http\Controllers;

use App\Quest;
use Illuminate\Http\Request;

class QuestController extends Controller
{
    public function index()
    {
        return Quest::with(['owner'])->get();
    }

    public function store(Request $request)
    {
        $quest = new Quest();
        $quest->fill($request->toArray());
        $quest->save();
    }
}
