<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    // no timestamps, please
    public $timestamps = false;

    protected $appends = ['expires_human'];

    protected $casts = [
            'subscription_date' => 'datetime',
            'subscription_expires' => 'datetime'
        ];

    public function getExpiresHumanAttribute()
    {
        return $this->subscription_expires->format('jS F Y');
    }

    public function streamer()
    {
        return $this->belongsTo(User::class, 'streamer_id', 'id');
    }

    public function subscriber()
    {
        return $this->belongsTo(User::class, 'subscriber_id', 'id');
    }

    public function tier()
    {
        return $this->belongsTo(Tier::class);
    }
}
