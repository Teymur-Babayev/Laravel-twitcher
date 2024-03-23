<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Overtrue\LaravelFollow\Traits\Follower;
use Overtrue\LaravelFollow\Traits\Followable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use Follower;
    use Followable;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $appends = ['firstCategory', 'moneyBalance', 'isBanned', 'firstName'];

    protected function profilePicture(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => is_null($value) ? Storage::disk('public')->url('profilePics/default-profile-pic.png') : Storage::disk('public')->url($value),
        );
    }

    public function getFirstNameAttribute()
    {
        $fullname = explode(" ", $this->name);
        return isset($fullname[0]) ? $fullname[0] : __('Me');
    }


    protected function coverPicture(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => is_null($value) ? Storage::disk('public')->url('coverPics/default-cover-pic.png') : Storage::disk('public')->url($value),
        );
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    protected function getFirstCategoryAttribute()
    {
        return $this->categories()->firstOr(function () {
            return (object)['id' => null, 'category' => null, 'slug' => null];
        });
    }

    public function scopeIsStreamer($query)
    {
        return $query->where('is_streamer', 'yes')->where('is_streamer_verified', 'yes');
    }

    public function getIsBannedAttribute()
    {
        return Banned::where('ip', $this->ip)->exists();
    }

    protected function getMoneyBalanceAttribute()
    {
        if (is_int($this->tokens)) {
            return opt('token_value') * $this->tokens;
        }

        return;
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function tiers()
    {
        return $this->hasMany(Tier::class);
    }

    public function hasSubscriptionTo(User $streamer)
    {
        return $this->subscriptions()->where('subscription_expires', '>=', now())
            ->where('streamer_id', $streamer->id)
            ->exists();
    }

    public function streamerBans()
    {
        return $this->hasMany(RoomBans::class, 'streamer_id');
    }

    public function bannedFromRooms()
    {
        return $this->hasMany(RoomBans::class, 'user_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'subscriber_id', 'id');
    }

    public function subscribers()
    {
        return $this->hasMany(Subscription::class, 'streamer_id', 'id')->where('subscription_expires', '>=', now());
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function purchasedVideos()
    {
        return $this->hasManyThrough(Video::class, VideoSales::class, 'user_id', 'id', 'id', 'video_id');
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function tipsGiven()
    {
        return $this->hasMany(Tips::class, 'user_id', 'id');
    }

    public function tipsReceived()
    {
        return $this->hasMany(Tips::class, 'streamer_id', 'id');
    }

    public function tokenOrders()
    {
        return $this->hasMany(TokenSale::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            DB::transaction(function () use ($user) {
                $user->purchasedVideos()->delete();
                $user->videos()->delete();
                $user->subscriptions()->delete();
                $user->tiers()->delete();
                $user->categories()->delete();
                $user->notifications()->delete();
                $user->chats()->delete();
                $user->tipsGiven()->delete();
                $user->tipsReceived()->delete();
                $user->withdrawals()->delete();

                DB::statement('DELETE FROM followables WHERE user_id = ? OR followable_id = ?', [$user->id, $user->id]);
            }, 3);
        });
    }
}
