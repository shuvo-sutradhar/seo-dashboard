<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{    

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cupon_code', 'description', 'discount_type','discount_duration','service_id','discount_amount','limit_1','total_limit','expiry_date','is_active'
    ];

    // Return many to one relation with discount_services table
    public function discount()
    {
        return $this->hasMany('App\DiscountService');
    }   
}
