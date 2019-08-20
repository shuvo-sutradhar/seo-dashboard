<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;

class Service extends Model
{
    use Sluggable;


	protected $fillable = [
        'name', 'description', 'price', 'thumbnail', 'display', 'requirments', 'deadline', 'deadline_number', 'deadline_type', 'order', 'is_active'
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


}
