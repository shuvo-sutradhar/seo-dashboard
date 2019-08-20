<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMessage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'sender_id', 'message_body', 'message_link', 'message_for', 'is_read', 'read_at'
    ];





    // Return one to many relationship with client
    public function messageOrder()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }


    // Return one to many relationship with client
    public function messageSender()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }


}
