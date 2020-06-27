<?php


namespace App\Repositories;


use App\Player;
use App\PlayerQuest;
use App\Quest;

class PlayerQuestRepository
{
    /**
     * Set status to player quest intermediate record.
     *
     * @param  Quest  $quest
     * @param  Player  $player
     * @param  int  $status
     *
     * @return PlayerQuest
     */
    public function setUserQuestState(Quest $quest, Player $player, int $status): PlayerQuest
    {
        $quest_state         = $this->getQuestState($quest, $player);
        $quest_state->status = $status;
        $quest_state->save();

        return $quest_state;
    }

    public function getQuestState(Quest $quest, Player $player): PlayerQuest
    {
        $quest_state = PlayerQuest::where('player_id', $player->id)->where('quest_id', $quest->id)->first();

        if(! $quest_state)
        {
            $quest_state = new PlayerQuest();
            $quest_state->player_id = $player->id;
            $quest_state->quest_id = $quest->id;
        }

        return  $quest_state;
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
