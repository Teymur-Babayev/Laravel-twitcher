<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $table = 'user_meta';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
