<?php

namespace App;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereColor1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereColor2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Person whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Person extends Model
{
    protected $table = 'persons';

    /**
     * @return BelongsToMany
     */
    public function quests()
    {
        return $this->belongsToMany(Quest::class);
    }

    public function motherQuests()
    {
        return $this->quests()->where('is_mother', true);
    }

    public function subQuests()
    {
        return $this->quests()->where('is_mother', false);
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



}
