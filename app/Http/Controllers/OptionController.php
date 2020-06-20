<?php

namespace App\Http\Controllers;

use App\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index()
    {
        return Option::all()->toArray();
    }

    public function storeMessage(Request $request)
    {
        Option::setValue('admin_message', $request->input('admin_message'));

        return response(null, 204);
    }
}
