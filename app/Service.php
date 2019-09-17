<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;

class Service extends Model
{
    use Sluggable;


	protected $fillable = [
        'name', 'description', 'thumbnail', 'service_type', 'price', 'recurring_duration' , 'recurring_for', 'deadline', 'is_active'
    ];



    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }




    //Relation with variants
    public function variants()
    {
    	return $this->hasMany('App\ServiceVariant');
    }

    // Return many to one relation with orders table
    public function serviceOrders()
    {
        return $this->hasMany('App\Order');
    }

    // Return many to one relation with invoice_items table
    public function serviceInvoices()
    {
        return $this->hasMany('App\InvoiceItem');
    }    

    // Return many to one relation with discount table
    public function discountService()
    {
        return $this->hasMany('App\DiscountService');
    }  

}
