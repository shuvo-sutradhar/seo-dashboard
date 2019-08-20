<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'phone', 'profile_picture', 'address', 'city', 'country', 'state', 'post_code', 'company_name', 'tax_id'
    ];




    // one to one relation with users table
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
