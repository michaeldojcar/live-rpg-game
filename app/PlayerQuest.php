<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PlayerQuest extends Pivot
{
    public const STATUS_LOCKED = 1;
    public const STATUS_AVAILABLE = 2;
    public const STATUS_PENDING = 3;
    public const STATUS_DONE = 4;
    public const STATUS_FAILED = 5;

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function quest()
    {
        return $this->belongsTo(Quest::class);
    }
}
