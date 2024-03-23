<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    public $with = ['user', 'streamer'];

    public $appends = ['isFollower', 'isSubscriber'];

    public function streamer()
    {
        return $this->belongsTo(User::class, 'streamer_id')->select(['id', 'username', 'profile_picture']);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->select(['id', 'username', 'profile_picture']);
    }

    public function getIsFollowerAttribute()
    {
        return $this->user->isFollowing($this->streamer);
    }

    public function getIsSubscriberAttribute()
    {
        return $this->user->hasSubscriptionTo($this->streamer);
    }
}
