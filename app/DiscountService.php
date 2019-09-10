<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountService extends Model
{
    //
    protected $fillable = [
        'discount_id', 'service_id', 'discount_amount'
    ];


    //Relation with discount
    public function discount()
    {
        return $this->belongsTo('App\Discount', 'discount_id');
    }
    //Relation with service
    public function discountService()
    {
        return $this->belongsTo('App\Service', 'service_id');
    }
}
