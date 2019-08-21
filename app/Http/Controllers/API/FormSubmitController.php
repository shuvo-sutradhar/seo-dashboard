<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Order;
use App\Invoice;
use App\InvoiceItem;
use App\InvoiceBilling;
use App\User;
use App\Client;

use Carbon\Carbon;
use Stripe;
use \Cartalyst\Stripe\Exception\CardErrorException;
use \Cartalyst\Stripe\Exception\BadRequestException;
use \Cartalyst\Stripe\Exception\InvalidRequestException;
use \Cartalyst\Stripe\Exception\NotFoundException;
use \Cartalyst\Stripe\Exception\ServerErrorException;
use App\Notifications\WelcomeClient;
use Auth;

class FormSubmitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    }

    //order form submit
    public function createOrder(Request $request){

        $this->validate($request, [
            'email' => 'required|string|max:191|unique:users'
        ]);


        $array = [];

        // check radio button data
        if($request->opt_single_service){
            $array1[] = array_push($array,$request->opt_single_service);
        }

        // check multiple checkbox data
        if($request->ckboxMultiServices){
            foreach ($request->ckboxMultiServices as $multiServcie) {
                array_push($array,$multiServcie);
            }
        }

        // check single dropdown data
        if($request->dropDownSingleService){
            if($request->dropSingleQty){
                $request->dropDownSingleService += ["quantity"=> (int)$request->dropSingleQty];
            } else {
                $request->dropDownSingleService += ["quantity"=> 1];
            }
            $array2[] = array_push($array,$request->dropDownSingleService);
        }

        // check multiple dropdown data
        if($request->dropDownMultipleServices){
            $i = 0;
            foreach ($request->dropDownMultipleServices as $multiDropdownSevrcie) {

                if($request->dropMultiQty && !is_null($request->dropMultiQty[$i])){
                    $multiDropdownSevrcie += ['quantity' => $request->dropMultiQty[$i]]; 
                } else {
                    $multiDropdownSevrcie += ['quantity' => 1]; 
                }

                //push data inside array
                array_push($array,$multiDropdownSevrcie);
                $i++;
            }
        }

        // return $request->stripeToken;
        try {
            $charge = Stripe::charges()->create([
                'amount' => $request->total,
                'currency' => 'USD',
                'source' => $request->stripeToken,
                'description' => 'Description goes here',
                'receipt_email' => $request->email,
                'metadata' => [
                    'data1' => 'metadata 1',
                    'data2' => 'metadata 2',
                    'data3' => 'metadata 3',
                ],
            ]);
            
            // save this info to your database
            $email_name = explode("@", $request->email);  
            $name = $request->name ? $request->name : $email_name[0];
            $password = $request->password ? $request->password : 123456;

            // Create profile for user
            $user = User::create([

                'name' => $name,
                'email' => $request->email,
                'password' => Hash::make($password),
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'account_role' => 2

            ]);
            

            // store data in client table
            if($request->address){

                $client = Client::create([

                    'user_id'       => $user->id,
                    'address'       => $request->address,
                    'city'          => $request->city,
                    'country'       => $request->country,
                    'state'         => $request->state,
                    'post_code'     => $request->postalCode,
                    'company_name'  => $request->companyName,
                    'tax_id'        => $request->taxId,

                ]);
            }

            // store data in database
            // unique order number
            $orderNumber = strtoupper(uniqid('CODE'));
            // insert row for every ervery service
            $i = 1;
            foreach($array as $key) {
                $order = Order::create([
                    'user_id' => $user->id,
                    'service_id' => $key['id'],
                    'team_member_id' => null,
                    'order_number' => $orderNumber.'_'.$i,
                    'order_note' => 'Write your order note',
                    'quantity' => $key['quantity'],
                    'order_status' => 'Pending',
                    'payment_staus' => 'By Card',
                ]);
                $i++;
            }

            // generate invoice for the order
            $invoice = Invoice::create([

                'order_id' => $order->id,
                'user_id' => $user->id,
                'invoice_number' => $orderNumber,
                'invoice_total' => $request->total,
                'invoice_discount' => 0.0,
                'invoice_vat' => 0.0,
                'invoice_status' => 'complete',
                'payment_method' => 'checkout',
                'payment_getway' => 'stripe'
            ]);

            // insert billing information 
            $invoiceBilling = InvoiceBilling::create([

                'invoice_id' => $invoice->id,
                'first_name' => $name,
                'email' => $request->email
            ]);


            // insert row for each billing item
            foreach($array as $key){
                $invoiceItem = InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'service_id' => $key['id'],
                    'quantity' => $key['quantity']
                ]);
            }
            
            // Create activity log 
            activity()->performedOn($user)->causedBy(auth()->user())->log('Created client account for '. $user->name);

            // Send mail notification
            $user->setAttribute('realPassword', 123456);
            $user->notify(new WelcomeClient($user));

            return  response()->json(compact('orderNumber'), 200);

        } catch (CardErrorException $e) {
            // save info to database for failed

            return "Something wrong";
        }

    }


}
