<?php


namespace App\Repositories;


use App\Player;
use App\Quest;

class PlayerRepository
{
    /**
     * Add amount of cash to player.
     *
     * @param  Player  $player
     * @param  int  $cash
     *
     * @return Player
     */
    public function addCashToPlayer(Player $player, int $cash): Player
    {
        $player->cash = $player->cash + $cash;
        $player->save();

        return $player;
    }

    /**
     * Remove amount of cash from player.
     *
     * @param  Player  $player
     * @param  int  $cash
     *
     * @return Player
     */
    public function removeCashFromPlayer(Player $player, int $cash): Player
    {
        $player->cash = $player->cash - $cash;
        $player->save();

        return $player;
    }

    public function addQuestRewardsToPlayer(Player $player, Quest $quest)
    {
        if ($quest->reward_cash)
        {
            $this->addCashToPlayer($player, $quest->reward_cash);
        }
    }
}
