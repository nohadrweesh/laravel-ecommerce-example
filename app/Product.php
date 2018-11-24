<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function presentPrice()
    {
        //return money_format('$%i', $this->price / 100);
        return '$'.number_format($this->price / 100, 2);
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }
    
    public function scopeMightAlsoLike($query){
        return $query->inRandomOrder()->take(4);
    }
}
