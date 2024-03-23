<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tier extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    public $appends = ['SixMonthsPrice', 'YearlyPrice'];

    public function getSixMonthsPriceAttribute()
    {
        return ceil(6*($this->price-(($this->price*$this->six_months_discount)/100)));
    }

    public function getYearlyPriceAttribute()
    {
        return ceil(12*($this->price-(($this->price*$this->one_year_discount)/100)));
    }

    public function subscribers()
    {
        return $this->hasManyThrough(Subscription::class, User::class, 'id', 'tier_id', 'id');
    }
}
