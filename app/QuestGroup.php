<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\QuestGroup
 *
 * @property int $id
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestGroup whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuestGroup extends Model
{
    public function quests()
    {
        return $this->hasMany(Quest::class);
    }
}
