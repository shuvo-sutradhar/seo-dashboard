<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
    protected $fillable = [
        'countrycode', 'countryname', 'code'
    ];

    public function client()
    {
        return $this->hasOne('App\Client');
    }

}
