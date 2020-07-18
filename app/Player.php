<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Player
 *
 * @package App
 * @property int $id
 * @property string $name
 * @property int $age
 * @property int $color_1
 * @property int $color_2
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Collection|Quest[] $quests
 * @property-read int|null $quests_count
 * @method static Builder|Player newModelQuery()
 * @method static Builder|Player newQuery()
 * @method static Builder|Player query()
 * @method static Builder|Player whereAge($value)
 * @method static Builder|Player whereColor1($value)
 * @method static Builder|Player whereColor2($value)
 * @method static Builder|Player whereCreatedAt($value)
 * @method static Builder|Player whereId($value)
 * @method static Builder|Player whereName($value)
 * @method static Builder|Player whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string $birth_date
 * @property int $color_3
 * @method static Builder|Player whereBirthDate($value)
 * @method static Builder|Player whereColor3($value)
 */
class Player extends Model
{
    protected $dates = [
        'birth_date',
        'last_seen',

    ];

    protected $appends = ['age', 'last_seen_string'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * @return BelongsToMany
     */
    public function quests()
    {
        return $this->belongsToMany(Quest::class)->withPivot('status');
    }

    public function motherQuests()
    {
        return $this->quests()->where('parent_quest_id', '=', null);
    }

    public function subQuests()
    {
        return $this->quests()->whereNotNull('parent_quest_id');
    }

    public function pendingQuestsForRole(Role $role)
    {
        return $this->motherQuests()
                    ->wherePivotIn('status', [
                        PlayerQuest::STATUS_PENDING,
                        PlayerQuest::STATUS_AVAILABLE
                    ])
                    ->where('quest_owner_id', $role->id);
    }

    public function pendingSubQuestsForRole(Role $role)
    {
        return $this->subQuests()
                    ->wherePivotIn('status', [
                        PlayerQuest::STATUS_PENDING,
                        PlayerQuest::STATUS_AVAILABLE
                    ])
                    ->where('quest_owner_id', $role->id);
    }

    public function getAgeAttribute()
    {
        return $this->birth_date->diffInYears();
    }

    public function getLastSeenStringAttribute()
    {
        if ( ! $this->last_seen)
        {
            return null;
        }

        return $this->last_seen->diffForHumans();
    }


    /**
     * Check if role is online.
     */
    public function isOnline()
    {
        return $this->last_seen > Carbon::now()->subSeconds(120);
    }

    public function getIsOnlineAttribute()
    {
        return $this->last_seen > Carbon::now()->subSeconds(120);
    }

    public function refreshLastSeen()
    {
        $this->last_seen = Carbon::now();
        $this->save();
    }

    public function refreshLocationAtRole(Role $role)
    {
        if ( ! $role->latitude || ! $role->longitude)
        {
            return;
        }

        $this->latitude  = $role->latitude;
        $this->longitude = $role->longitude;
        $this->save();
    }

    public function doneQuests()
    {
        return $this->quests()->wherePivot('status', PlayerQuest::STATUS_DONE);
    }
}
