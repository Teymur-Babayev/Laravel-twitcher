<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Video extends Model
{
    use HasFactory;

    public $appends = ['videoUrl', 'slug', 'canBePlayed'];
    public $with = ['category'];

    public function streamer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function thumbnail(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Storage::disk($this->disk)->url($value),
        );
    }

    protected function getVideoUrlAttribute()
    {
        return Storage::disk($this->disk)->url($this->video);
    }

    // slug attribute
    public function getSlugAttribute()
    {
        return Str::slug($this->title);
    }

    public function sales()
    {
        return $this->hasMany(VideoSales::class);
    }

    public function category()
    {
        return $this->belongsTo(VideoCategories::class);
    }

    public function getCanBePlayedAttribute()
    {
        // if video is free, allow anyone to view
        if ($this->price === 0) {
            return true;
        }

        // if video owner, allow to view his own vid
        if (auth()->id() == $this->user_id) {
            return true;
        }

        // if it's free for subscribers and current user is one of them
        if (auth()->check() && $this->free_for_subs == "yes" && auth()->user()->hasSubscriptionTo($this->streamer)) {
            return true;
        }

        // if there's an order for this video
        if (auth()->check()) {
            return $this->sales()
                        ->where('video_id', $this->id)
                        ->where('user_id', auth()->id())
                        ->exists();
        }


        return false;
    }
}
