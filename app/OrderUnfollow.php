<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderUnfollow extends Model
{
    
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_unfollows';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'order_id', 'user_id', 'is_following'
    ];


    // Return one to many relationship orders
    public function followingOrder()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }


    // Return one to many relationship orders
    public function userFollowingOrder()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

     // Return one to many relationship orders
    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }


}
