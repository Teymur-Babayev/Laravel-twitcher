<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    // no timestamps, please
    public $timestamps = false;

    public $appends = ['slug'];

    // relationship to
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // slug attribute
    public function getSlugAttribute()
    {
        return Str::slug($this->category);
    }
}
