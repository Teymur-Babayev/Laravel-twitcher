<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tips extends Model
{
    // relation to tipper
    public function tipper()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // relation to tipper
    public function stremer()
    {
        return $this->belongsTo(User::class, 'streamer_id');
    }
}
