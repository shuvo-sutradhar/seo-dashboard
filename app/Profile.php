<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id', 'contact_number', 'profile_picture'
    ];



    // one to one relation with user
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
