<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    // fillable
    protected $fillable = ['page_title', 'page_content', 'page_slug'];

    public function getRouteKeyName()
    {
        return 'page_slug';
    }

    public static function slug(Page $p)
    {
        return route('page', ['page' => $p]);
    }

    public function getSlugAttribute()
    {
        return '/' . $this->page_type . '/' . $this->id . '-' . Str::slug($this->page_title);
    }

    public function scopePages($query)
    {
        $query->where('page_type', 'page');
    }

    public function scopePosts($query)
    {
        $query->where('page_type', 'post');
    }
}
