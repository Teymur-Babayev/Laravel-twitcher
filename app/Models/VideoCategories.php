<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VideoCategories extends Model
{
    use HasFactory;

    public $table = 'video_categories';
    public $appends = ['slug'];
    public $timestamps = false;

    public function videos()
    {
        return $this->hasMany(Video::class, 'category_id');
    }

    // slug attribute
    public function getSlugAttribute()
    {
        return Str::slug($this->category);
    }
}
