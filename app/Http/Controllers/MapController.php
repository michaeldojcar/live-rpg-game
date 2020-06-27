<?php

namespace App\Http\Controllers;

use App\Player;
use App\Role;

class MapController extends Controller
{
    /**
     * Roles for OSM map view.
     *
     * @return string
     */
    public function mapIndex()
    {
        // Active roles
        $roles = Role::all();

        $roles = $roles->filter(function (Role $role)
        {
            $valid_coords = $role->latitude && $role->longitude;

            return $valid_coords && $role->getIsOnlineAttribute();
        });

        // Active players
        $players = Player::all();

        $players = $players->filter(function (Player $player)
        {
            $valid_coords = $player->latitude && $player->longitude;

            return $valid_coords && $player->getIsOnlineAttribute();
        });

        $response = [
            'players'=>$players,
            'roles'=>$roles,
        ];

        return response($response);
    }
}
