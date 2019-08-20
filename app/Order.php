<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';




    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'service_id', 'team_member_id', 'order_number', 'order_note', 'quantity', 'order_total', 'order_status', 'payment_staus'
    ];



    // Return ont to many relationship with client
    public function orderClinet()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }


    // Return one to many relationship with client
    public function orderService()
    {
        return $this->belongsTo('App\Service', 'service_id');
    }


    // Return ne to many realationship with order message
    public function orderMessages()
    {
        return $this->hasMany('App\OrderMessage');
    }


    // Return one to many relationship with client
    public function orderTeam()
    {
        return $this->belongsTo('App\User', 'team_member_id');
    }

    // Return one to many realationship with order follow
    public function followOrUnfollow()
    {
        return $this->hasMany('App\OrderUnfollow');
    }





    // Return message for each order
    public function messageCount()
    {
        return $this->orderMessages->count();
    }

    // Return order follow or unfollow
    public function teamFollowOrders()
    {
        return $this->hasMany('App\OrderUnfollow');
    }







    
}
