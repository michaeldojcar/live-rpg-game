<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Log
 *
 * @property int $id
 * @property string $action
 * @property int|null $player_id
 * @property int|null $role_id
 * @property int|null $quest_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Log newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Log newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Log query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Log whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Log whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Log wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Log whereQuestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Log whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Log whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Log extends Model
{
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function quest()
    {
        return $this->belongsTo(Quest::class);
    }
}
