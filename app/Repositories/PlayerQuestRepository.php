<?php


namespace App\Repositories;


use App\Player;
use App\PlayerQuest;
use App\Quest;

class PlayerQuestRepository
{
    public function setUserQuestState(Quest $quest, Player $player, int $status)
    {
        $player_quest         = $this->getQuestState($quest, $player);
        $player_quest->status = $status;
        $player_quest->save();
    }

    public function getQuestState(Quest $quest, Player $player): PlayerQuest
    {
        return PlayerQuest::where('player_id', $player->id)->where('quest_id', $quest->id)->firstOrFail();
    }

    /**
     * Set quest and all its sub-quests done.
     *
     * @param  Quest  $quest
     * @param  Player  $player
     *
     * @return bool
     */
    public function setQuestWithAllChildsDone(Quest $quest, Player $player)
    {
        $this->setUserQuestState($quest, $player, PlayerQuest::STATUS_DONE);

        while ($quest->sub_quest)
        {
            $this->setUserQuestState($quest, $player, PlayerQuest::STATUS_DONE);

            $quest = $quest->sub_quest;
        }

        return true;
    }

    public function setQuestWithAllChildsFailed(Quest $quest, Player $player)
    {
        $this->setUserQuestState($quest, $player, PlayerQuest::STATUS_FAILED);

        while ($quest->sub_quest)
        {
            $this->setUserQuestState($quest, $player, PlayerQuest::STATUS_FAILED);

            $quest = $quest->sub_quest;
        }

        return true;
    }
}
