<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceBilling extends Model
{
    
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoice_billings';

    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id', 'first_name', 'last_name', 'email', 'phone', 'company_name', 'tax_id', 'address', 'city', 'country', 'state', 'post_code'
    ];

    // Return many to one relation with invoice_items table
    public function invoice()
    {
        return $this->hasOne('App\Invoice');
    } 
}
