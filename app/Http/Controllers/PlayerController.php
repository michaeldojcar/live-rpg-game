<?php

namespace App\Http\Controllers;

use App\Helper\ColorCombination;
use App\Player;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Exception;

class PlayerController extends Controller
{
    public function index()
    {
        return Player::all();
    }

    public function show($id)
    {
        $player = Player::findOrFail($id);
        return $player;
    }
    public function store(Request $request)
    {
        $player = new Player();
        $player->name = $request->input('name');
        $player->birth_date = $request->input('birth_date');

        $colorCombination = $this->getUnusedColorCombination();
        $player->color_1 = $colorCombination->color1;
        $player->color_2 = $colorCombination->color2;
        $player->color_3 = $colorCombination->color3;

        $player->save();
    }

    private function getUnusedColorCombination(): ColorCombination
    {
        $players = Player::all();

        for ($temp = new ColorCombination(); $temp->isMax() == false; $temp->increment())
        {
            if ($this->isCombinationUnused($temp, $players))
            {
                return $temp;
            }
        }

        throw new Exception("No unused combination available.");
    }

    private function isCombinationUnused(ColorCombination $colorCombination, Collection $players): bool
    {
        foreach ($players as $player)
        {
            $isSame = $this->isPlayerCombinationSame($colorCombination, $player);
            if ($isSame)
            {
                return false;
            }
        }

        return true;
    }

    private function isPlayerCombinationSame(ColorCombination $colorCombination, Player $player): bool
    {
        if ($colorCombination->color1 != $player->color_1)
        {
            return false;
        }

        if ($colorCombination->color2 != $player->color_2)
        {
            return false;
        }

        if ($colorCombination->color3 != $player->color_3)
        {
            return false;
        }

        return true;
    }
}
