<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Role
 *
 * @property int $id
 * @property string $name
 * @property string $real_name
 * @property string $story
 * @property string $action_recommends
 * @property string $place_recommends
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereActionRecommends($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role wherePlaceRecommends($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereRealName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereStory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
    protected $dates = ['last_seen'];

    /**
     * Check if role is online.
     */
    public function isOnline()
    {
        return $this->last_seen > Carbon::now()->subSeconds(20);
    }
}
