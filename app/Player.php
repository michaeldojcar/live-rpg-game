<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Person
 * 1 hráč hry
 *
 * @package App
 * @property int $id
 * @property string $name
 * @property int $age
 * @property int $color_1
 * @property int $color_2
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Quest[] $quests
 * @property-read int|null $quests_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Player newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Player newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Player query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Player whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Player whereColor1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Player whereColor2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Player whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Player whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Player whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Player whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $birth_date
 * @property int $color_3
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Player whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Player whereColor3($value)
 */
class Player extends Model
{
    protected $dates = ['birth_date'];

    public function group()
    {
        return $this->belongsToMany(Group::class)->first();
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
        return $this->quests()->where('parent_quest_id', '!=', null);
    }

    public function pendingQuestsForRole(Role $role)
    {
        return $this->motherQuests()
            ->wherePivot('status', 3)
            ->where('quest_owner_id', $role->id);
    }

    public function availableQuestsForRole(Role $role)
    {
        return $this->motherQuests()
            ->wherePivot('status', 2)
            ->where('quest_owner_id', $role->id);
    }

    public function pendingSubQuestsForRole(Role $role)
    {
        return $this->subQuests()
            ->wherePivot('status', 3)
            ->where('quest_owner_id', $role->id);
    }

    public function getAgeAttribute()
    {
        return $this->birth_date->diffInYears();
    }

    protected $appends = ['age'];

}
