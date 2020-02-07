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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Person[] $persons
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
 */
class Quest extends Model
{
    public function motherQuest()
    {
        return $this->belongsTo(Quest::class, 'mother_quest_id');
    }

    public function owner()
    {
        return $this->belongsTo(Role::class, 'quest_owner_id');
    }

    public function persons()
    {
        return $this->belongsToMany(Person::class)->withPivot('status');
    }
}
