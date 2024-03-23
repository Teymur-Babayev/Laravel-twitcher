<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomBans extends Model
{
    use HasFactory;

    public $appends = ['banned_at_human'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function streamer()
    {
        return $this->belongsTo(User::class, 'streamer_id');
    }

    public function getBannedAtHumanAttribute()
    {
        return $this->created_at->format('jS F Y');
    }
}
