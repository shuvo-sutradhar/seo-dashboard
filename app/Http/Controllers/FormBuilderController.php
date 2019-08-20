<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OrderForm;
use App\Invoice;
use Illuminate\Support\Facades\Auth;

class FormBuilderController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $orderForms = OrderForm::select('id','formName','formLink')->where('status',1)->get();
        return view('order-form.index',compact('orderForms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('order-form.create');
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
        $formData = OrderForm::findOrFail($id);
        return view('order-form.edit',compact('formData'));
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
    public function order($link)
    {
        //
        $formData = OrderForm::where('formLink',$link)->where('status',1)->first();
        return view('order-form.order',compact('formData'));
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




    // thanks after complete order
    public function thanks(Request $request){


        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $invoice = Invoice::where('invoice_number', $request->order_id)->firstOrFail();
            return view('order-form.thanks',compact('invoice'));
            
        }
    }
}
