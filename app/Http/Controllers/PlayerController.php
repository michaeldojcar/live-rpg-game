<?php

namespace App\Http\Controllers;

use App\Helper\ColorCombination;
use App\Http\Requests\PlayerStoreRequest;
use App\Http\Requests\PlayerUpdateRequest;
use App\Player;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    public function store(PlayerStoreRequest $request)
    {
        $player             = new Player();
        $player->name       = $request->input('name');
        $player->birth_date = $request->input('birth_date');

        $colorCombination = $this->getUnusedColorCombination();
        $player->color_1  = $colorCombination->color1;
        $player->color_2  = $colorCombination->color2;
        $player->color_3  = $colorCombination->color3;

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

    public function update($id, PlayerUpdateRequest $request)
    {
        // Parse birth date
        $birth_date = Carbon::parse($request->input('birth_date'));

        // Update model
        $player = $this->findById($id);

        $player->name       = $request->input('name');
        $player->birth_date = $birth_date;
        $player->save();

        return response($player, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $player = $this->findById($id);

        // Detach related records
        $player->quests()->detach();
        $player->group_id = null;

        $player->delete();

        return response('Player was deleted.', Response::HTTP_NO_CONTENT);
    }

    /**
     * Find model by id.
     *
     * @param $id
     *
     * @return Player|Player[]|Collection|Model
     */
    private function findById($id): Player
    {
        return Player::findOrFail($id);
    }
}
