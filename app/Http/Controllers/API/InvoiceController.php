<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\User;
use App\Service;
use App\Order;
use App\InvoiceBilling;
use App\InvoiceItem;
use App\GeneralSetting;
use App\Client;

class InvoiceController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total        = Invoice::count(); 
        $paid_total   = Invoice::where('invoice_status','paid')->count(); 
        $unpaid_total = Invoice::where('invoice_status','unpaid')->count(); 
        $refund_total = Invoice::where('invoice_status','refund')->count(); 
        //
        $invoices     = Invoice::with('invoiceItems')->with('invoiceClient')->paginate(10);  

        return  response()->json(compact('total','paid_total','unpaid_total','refund_total','invoices'), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $users = User::where('account_role',2)->get();
        $services = Service::where('is_active',1)->get();
        return  response()->json(compact('users','services'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'client' => 'required',
        ]);

        // return $request->due_date;
        
        //unique order number
        $orderNumber = strtoupper(uniqid('CODE'));
        // insert row for every ervery service
        $i = 1;
        $total = 0;
        $discount = 0;

        foreach($request->items as $key){

            //get total amount / discount / vat 
            if($key['selectedService']['id']==0){
                $total += $key['servicePrice'] * $key['serviceQty'];
            } else {
                $total += $key['selectedService']['price'] * $key['serviceQty'];
            }
            // all discount
            $discount += $key['serviceDiscount'];


            //check if the service new then add it into service table 1st
            if($key['selectedService']['id']==0) {


                $service = Service::create([
                    'name' => $key['serviceName'],
                    'description' => $key['description'],
                    'price' => $key['servicePrice'],
                    'display' => 0,
                    'requirments' => 0,
                    'is_active' => 0,
                ]);

            } 

            $order = Order::create([
                'user_id' => $request->client['id'],
                'service_id' => $key['selectedService']['id']==0 ? $service->id : $key['selectedService']['id'],
                'team_member_id' => null,
                'order_number' => $orderNumber.'_'.$i,
                'order_note' => 'Write your order note',
                'quantity' => $key['serviceQty'],
                'order_status' => 'unpaid',
                'payment_staus' => 'Manual',
            ]);
            $i++;
        }


        // generate invoice for the order
        $invoice = Invoice::create([

            'order_id' => $order->id,
            'user_id' => $request->client['id'],
            'invoice_number' => $orderNumber,
            'invoice_total' => $total ,
            'invoice_discount' => $discount,
            'invoice_vat' => 0.0,
            'invoice_status' => 'unpaid',
            'due_date' => $request->due_date,
            'invoice_note' => $request->invoice_note,

        ]);


        // insert billing information 
        $client = Client::where('user_id',$request->client['id'])->first();
        $invoiceBilling = InvoiceBilling::create([

            'invoice_id' => $invoice->id,
            'first_name' => $request->client['name'],
            'email' => $request->client['email'],
            'phone' => $client ? $client->phone : '',
            'company_name' => $client ? $client->company_name : '',
            'tax_id' => $client ? $client->tax_id : '',
            'address' => $client ? $client->address : '',
            'city' => $client ? $client->city : '',
            'country' => $client ? $client->country : '',
            'state' => $client ? $client->state : '',
            'post_code' => $client ? $client->post_code : '',
        ]);

        // insert row for each billing item
        foreach($request->items as $key){
            $invoiceItem = InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'service_id' => $key['selectedService']['id']==0 ? $service->id : $key['selectedService']['id'],
                'quantity' => $key['serviceQty']
            ]);
        }

        // Send mail notification
        if($request->send_email == true){
           //send mail 
        }

        return  ['message'=>'successfully inserted.'];

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($invoice_number)
    {
        //
        $invoice = Invoice::with('invoiceClient')->with('invoiceOrder')->with('invoiceBill')->where('invoice_number', $invoice_number)->firstOrFail();
        $invoice_item = InvoiceItem::with('invoiceService')->where('invoice_id',$invoice->id)->get();
        $generalSetting = GeneralSetting::all();
        return  response()->json(compact('invoice','invoice_item','generalSetting'), 200);
    }
    /**
     * Display the specified resource.
     *
     */
    public function makeAsPaid($id)
    {
        // update invoice table data
        $invoice = Invoice::findOrFail($id);
        if($invoice->invoice_status == 'unpaid') {
            $invoice->update([
                'invoice_status' => 'paid'
            ]);
            $message = 'Order make as paid';
        } else {
            $invoice->update([
                'invoice_status' => 'unpaid'
            ]);
            $message = 'Order make as unpaid';
        }

        // update invoice table data
        $order = Order::findOrFail($invoice->order_id);
        if($order->order_status == 'unpaid') {
            $order->update([
                'order_status' => 'Submitted'
            ]);
            $message = 'Order make as paid';
        } else {
            $order->update([
                'order_status' => 'unpaid'
            ]);
            $message = 'Order make as unpaid';
        }
        return ['message'=>$message];
    }


    /**
     * update invoice address
     *
     */
    public function address(Request $request,$id)
    {
        
        $invvoiceBill = InvoiceBilling::findOrFail($id);

        $this->validate($request,[
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
        ]);

        $invvoiceBill['first_name'] = $request->first_name;
        $invvoiceBill['last_name'] = $request->last_name;
        $invvoiceBill['address'] = $request->address;
        $invvoiceBill['country'] = $request->country;
        $invvoiceBill['city'] = $request->city;
        $invvoiceBill['state'] = $request->state;
        $invvoiceBill['post_code'] = $request->post_code;
        $invvoiceBill['company_name'] = $request->company_name;
        $invvoiceBill['tax_id'] = $request->tax_id;

        $invvoiceBill->update();

        return ['message' => 'Updated invoice billing address.'];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($invoice_number)
    {
        //
        $users = User::where('account_role',2)->get();
        $services = Service::all();
        $invoice = Invoice::with('invoiceClient')->with('invoiceItems')->with('invoiceBill')->where('invoice_number', $invoice_number)->first();
        $invoice_item = InvoiceItem::with('invoiceService')->where('invoice_id',$invoice->id)->get();
        return  response()->json(compact('invoice','users','services','invoice_item'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return Invoice::destroy($id);
    }
}
