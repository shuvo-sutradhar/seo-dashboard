<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoice_item';



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id', 'service_id', 'quantity'
    ];


    //realtion with invoice 
    public function invoiceService()
    {
        return $this->belongsTo('App\Service', 'service_id');
    }



    //realtion with invoice 
    public function invoice()
    {
        return $this->belongsTo('App\Invoice', 'invoice_id');
    }
}
