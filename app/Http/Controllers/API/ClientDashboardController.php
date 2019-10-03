<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\InvoiceItem;
use App\GeneralSetting;

class ClientDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Get all invoice data
     */
    public function invoice() {

        return Invoice::with('invoiceItems')->with('invoiceClient')->where('user_id', auth('api')->user()->id)->latest()->paginate(10); 

    }
    /**
     * Get all invoice data
     */
    public function showInvoiceDetils($invoice_number) {

        $invoice = Invoice::with('invoiceClient')->with('invoiceOrder')->with('invoiceBill')->where('invoice_number', $invoice_number)->where('user_id',auth('api')->user()->id)->firstOrFail();
        $invoice_item = InvoiceItem::with('invoiceService')->where('invoice_id',$invoice->id)->get();
        $generalSetting = GeneralSetting::all();
        return  response()->json(compact('invoice','invoice_item','generalSetting'), 200);
        
    }
}
