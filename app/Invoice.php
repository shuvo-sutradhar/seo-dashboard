<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoices';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'user_id', 'invoice_number', 'invoice_note', 'invoice_total', 'invoice_discount', 'invoice_vat', 'invoice_status', 'payment_getway', 'payment_method', 'error','due_date'
    ];



    // Return many to one relation with invoice_items table
    public function invoiceItems()
    {
        return $this->hasMany('App\InvoiceItem');
    }    
    // Return many to one relation with invoice_items table
    public function invoiceBill()
    {
        return $this->hasOne('App\InvoiceBilling');
    }    

    //Relation with service
    public function invoiceClient()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    //Relation with order
    public function invoiceOrder()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }
}
