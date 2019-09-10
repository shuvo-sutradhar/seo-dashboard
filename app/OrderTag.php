<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class OrderTag extends Model
{
    protected $fillable = [
        'order_id', 'tag_id'
    ];



    // Return one to many relationship tag
    public function orderTag()
    {
        return $this->belongsTo('App\Tag', 'tag_id');
    }


    // Return one to many relationship orders
    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }
	
}
