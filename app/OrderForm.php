<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderForm extends Model
{
    //
    protected $fillable = [
        'formName', 'formLink', 'formInfo', 'cuponCode', 'orderForm', 'status'
    ];



    // Return ne to many realationship with order message
    public function order()
    {
        return $this->hasMany('App\Order');
    }
}
