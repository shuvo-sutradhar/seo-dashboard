<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use App\Service;

class OrderController extends Controller
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
        $count1 = Order::count(); 
        $count2 = Order::where('order_status','Pending')->count(); 
        $count3 = Order::where('order_status','Submitted')->count(); 
        $count4 = Order::where('order_status','Working')->count(); 
        $count5 = Order::where('order_status','Complete')->count(); 
        $count6 = Order::where('order_status','Canceled')->count(); 
        $orders = Order::with('orderService')->with('orderClinet')->with('orderTeam')->paginate(10);
        
        $users = User::where('account_role',2)->get(); 
        $services = Service::where('is_active',1)->get();
        
        return  response()->json(compact('count1','count2','count3','count4','count5','count6','orders','users','services'), 200);
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
        //
        $this->validate($request,[
            'client'   => 'required',
            'service'   => 'required',
        ]);

        $input['user_id']         = $request->client['id'];
        $input['service_id']      = $request->service['id'];
        $input['team_member_id']  = null;
        $input['order_number']    = strtoupper(uniqid('CODE'));
        $input['order_note']      = null;
        $input['quantity']        = 1;
        $input['order_status']    = 'Pending';
        $input['payment_staus']   = 'Not paid';
        
        $order = Order::create($input);

        return  response()->json(compact('order'), 200);
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

        return Order::destroy($id);
    }
}
