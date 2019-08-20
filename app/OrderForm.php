<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderForm extends Model
{
    //
    protected $fillable = [
        'formName', 'formLink', 'formInfo', 'cuponCode', 'orderForm', 'status'
    ];
}
