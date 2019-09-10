<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use App\Service;
use App\OrderUnfollow;
use Carbon\Carbon;
use App\Tag;
use App\OrderTag;
use Auth;

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
        $count1 = Order::where('order_status','!=','unpaid')->count(); 
        $count2 = Order::where('order_status','Pending')->count(); 
        $count3 = Order::where('order_status','Submitted')->count(); 
        $count4 = Order::where('order_status','Working')->count(); 
        $count5 = Order::where('order_status','Complete')->count(); 
        $count6 = Order::where('order_status','Canceled')->count(); 
        $orders = Order::with('orderService')->with('orderClient')->with('orderTeam')->with('orderTeam')->where('order_status','!=','unpaid')->paginate(10);
        
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
     * store order note data
     *
    */
    public function order_note(Request $request,$id)
    {
        $order              = Order::find($id);
        $order->order_note  = $request->data;
        $order->save();
        return ['message'=>'Successfuly inserted.'];
    }

    /**
     * change order status data
     *
    */
    public function order_status(Request $request,$id)
    {
        $order              = Order::find($id);
        $order->order_status  = $request->data;

        if($request->data=='Complete') {
            if($order->strated_at==null){
                $order->strated_at  = Carbon::now()->format('Y-m-d H:i:s');
            }
            $order->completed_at  = Carbon::now()->format('Y-m-d H:i:s');

        } elseif ($request->data!='Submitted' || $request->data!='Working'){

            $order->strated_at  = Carbon::now()->format('Y-m-d H:i:s');
            $order->completed_at  = NULL;

        } else {
            $order->completed_at  = NULL;
        }
        $order->save();
        return ['message'=>'Successfuly inserted.'];
    }


    
    /**
     * follow or unflow order
     *
    */
    public function order_follow($number)
    {
        $order = Order::where('order_number', $number)->firstOrFail();

        $matchThese = ['order_id' => $order->id, 'user_id' => auth()->user()->id];

        $unfollow = OrderUnfollow::where($matchThese)->first();

        if(isset($unfollow->is_following))
        {
            $isFollowing = true;

            if($unfollow->is_following == true)
            {
                $isFollowing = false;
            }
           
            $unfollow->update([
                'is_following' => $isFollowing,
            ]);

            if($isFollowing)
            {
                return ['You are now following the orde.'];
            }
            return ['You are now unfollowing the order.'];
        }
        else
        {
            OrderUnfollow::create([
                'order_id' => $order->id,
                'user_id' => auth()->user()->id,
                'is_following' => 1,

            ]);
        }
        return ['You are now following the orde.'];
    }


    /**
     * assign order.
     *
    */
    public function assign_orders(Request $request, $number)
    {

        $order = Order::where('order_number', $number)->firstOrFail();

        if($request->data == 'anyone')
        {
            $team = null;
        }
        else
        {
            $team = $request->data;
        }
        $order->update([
            'team_member_id' => $team
        ]);

        return ['message'=>'Order has been assign.'];
    }

    /**
     * order tag create.
     *
    */
    public function order_tag(Request $request, $id)
    {

        $tag = Tag::create([
            'id' => $request->tag['id'],
            'name' => $request->tag['name'],
        ]);

        return  response()->json(compact('tag'), 200);
    }

    /**
     * tag_orders.
     *
    */
    public function tag_orders(Request $request,$id)
    {
        $order = Order::findOrFail($id);
        if($request->tag!=null){
            foreach ($request->tag as $tag) {

                $matchThese = ['order_id' => $id, 'tag_id' => $tag['id']];
                $orderTags = OrderTag::where($matchThese)->get();
                //return $orderTags;
                if(count($orderTags) == 0){
                    OrderTag::create([
                        'order_id' => $id,
                        'tag_id' => $tag['id']
                    ]);

                }
            }
        }


        return ['test'];
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($order_number)
    {
        //
        $order = Order::with('orderClient')->with('orderService')->with('orderForm')->with('invoice')->with('orderTeam')->where('order_number', $order_number)->firstOrfail();
        $teamMembers = User::where('account_role', 0)->orWhere('account_role',1)->get();
        $matchThese = ['order_id' => $order->id, 'user_id' => auth('api')->id()];
        $followOrUnfollow = OrderUnfollow::where($matchThese)->first();
        $tags = Tag::all();
        $order_tag = OrderTag::with('orderTag')->where('order_id',$order->id)->get();
        $user =  Auth::user();

        return  response()->json(compact('order', 'teamMembers', 'followOrUnfollow','tags','order_tag','user'), 200);

    }

    /**
     * Delete Assign tag into order
     *
     */
    public function order_tag_delete($id)
    {
        //
        return OrderTag::destroy($id);

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
