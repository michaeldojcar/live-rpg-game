<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 1 quest
 * 
 * Class Quest
 *
 * @package App
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $task_type
 * @property int $is_mother
 * @property int $mother_quest_id
 * @property int $unlock_criteria
 * @property int $allow_more_attempts
 * @property int $allow_finish_repeatedly
 * @property int $quest_owner_id
 * @property string $reward_cash
 * @property string $reward_knowledge
 * @property int $reward_quest_unlock_id
 * @property int $is_reward_public
 * @property int $is_dumb
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Quest $motherQuest
 * @property-read \App\Role $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Player[] $persons
 * @property-read int|null $persons_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereAllowFinishRepeatedly($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereAllowMoreAttempts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereIsDumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereIsMother($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereIsRewardPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereMotherQuestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereQuestOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereRewardCash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereRewardKnowledge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereRewardQuestUnlockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereTaskType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereUnlockCriteria($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $parent_quest_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereParentQuestId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Quest[] $sub_quests
 * @property-read int|null $sub_quests_count
 * @property-read mixed $chain_quests
 * @property-read \App\Quest|null $parentQuest
 * @property int $age_from
 * @property int $age_to
 * @property int $quest_group_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereAgeFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereAgeTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereQuestGroupId($value)
 * @property-read \App\Quest $sub_quest
 * @property-read \App\Quest|null $parent_quest
 */
class Quest extends Model
{
    protected $guarded = [];

    public function parent_quest()
    {
        return $this->belongsTo(Quest::class, 'parent_quest_id');
    }

    /**
     * Mother quest
     *
     * @return $this|\App\Quest|null
     */
    public function motherQuest()
    {
        if ($this->parent_quest_id == null)
        {
            return Quest::find($this->id);
        }

        $parent = $this->parent_quest;

        while ($parent->parent_quest)
        {
            $parent = $parent->parent_quest;
        }

        return $parent;
    }

    /**
     * Find the lowest sub-quest of this quest.
     *
     * @return Quest
     */
    public function getLastSubQuest(): Quest
    {
        // 1. Quest is the last quest
        if ($this->sub_quest === null)
        {
            return Quest::find($this->id);
        }

        $sub_quest = $this->sub_quest;

        while ($sub_quest->sub_quest)
        {
            $sub_quest = $sub_quest->sub_quest;
        }

        return $sub_quest;
    }

    public function owner()
    {
        return $this->belongsTo(Role::class, 'quest_owner_id');
    }

    public function persons()
    {
        return $this->belongsToMany(Player::class)->withPivot('status');
    }

    public function sub_quests()
    {
        return $this->hasMany(Quest::class, 'parent_quest_id');
    }

    public function sub_quest()
    {
        return $this->hasOne(Quest::class, 'parent_quest_id');
    }

    /**
     * Get collection of mother and subquests.
     *
     * @return mixed
     */
    public function getChainQuestsAttribute()
    {
        $chain_collection = collect();

        // Add mother quest
        $mother = $this->motherQuest();

//        dd($mother);

        $chain_collection->add($mother);

        // Add first sub-quest
        if ($mother->sub_quests->first())
        {
            $subquest = $mother->sub_quests()->first();  // Mother first subquest
            $chain_collection->add($subquest);

            // Add more subquests
            while ($subquest->sub_quests()->count() > 0)
            {
                $subquest = $subquest->sub_quests()->first();
                $chain_collection->add($subquest);
            }
        }

        return $chain_collection;
    }
}
