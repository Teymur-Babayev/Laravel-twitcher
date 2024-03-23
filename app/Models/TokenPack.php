<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenPack extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $appends = ['tokensFormatted'];

    public function getTokensFormattedAttribute()
    {
        return number_format($this->tokens, 0);
    }
}
