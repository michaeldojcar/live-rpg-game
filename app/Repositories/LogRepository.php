<?php


namespace App\Repositories;


use App\Log;
use App\Player;
use App\Quest;
use App\Role;

class LogRepository
{
    /**
     * Create new log entry.
     *
     * @param  string  $action
     * @param  Player|null  $player
     * @param  Role|null  $role
     * @param  Quest|null  $quest
     *
     * @return Log
     */
    public function create(string $action, Player $player = null, Role $role = null, Quest $quest = null): Log
    {
        $log            = new Log();
        $log->action    = $action;
        $log->player_id = @$player->id;
        $log->role_id   = @$role->id;
        $log->quest_id  = @$quest->id;
        $log->save();

        return $log;
    }

    /**
     * Log that player has been logged by some role.
     *
     * @param  Player  $player
     * @param  Role  $role
     *
     * @return bool
     */
    public function playerLogged(Player $player, Role $role): bool
    {
        $this->create('player_logged', $player, $role);

        return true;
    }
}
