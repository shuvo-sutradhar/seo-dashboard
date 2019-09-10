<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderMessage;
use App\Events\NewOrderMessage;

class OrderMessageController extends Controller
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
        // return $request->message_link;
        //
        $input['order_id']        = $request->order_id;
        $input['sender_id']       = auth()->user()->id;
        $input['message_body']    = $request->mesasge_body;
        $input['message_link']   = $request->message_link;
        $input['message_for']    = $request->message_for;
        
        $orderMessage = OrderMessage::Create($input);


        broadcast(new NewOrderMessage($orderMessage));

        return  response()->json(compact('orderMessage'), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($order_num)
    {
        $order = Order::where('order_number',$order_num)->first();

        $orderMessage = OrderMessage::with('messageSender')->where('order_id',$order->id)->get();
        return  response()->json(compact('orderMessage'), 200);
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
        return OrderMessage::destroy($id);
    }
}
