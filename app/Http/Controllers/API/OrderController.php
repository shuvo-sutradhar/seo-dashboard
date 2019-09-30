<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use App\Invoice;
use App\InvoiceItem;
use App\Service;
use App\OrderUnfollow;
use Carbon\Carbon;
use App\Tag;
use App\OrderTag;
use Auth;
use App\Notifications\OrderAssign;

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
    // public function index()
    // {
        
    //     if(Auth()->user()->account_role == 2) {
    //         $count1 = Order::where('order_status','!=','unpaid')->where('user_id',Auth()->user()->id)->count(); 
    //         $count2 = Order::where('order_status','Pending')->where('user_id',Auth()->user()->id)->count(); 
    //         $count3 = Order::where('order_status','Submitted')->where('user_id',Auth()->user()->id)->count(); 
    //         $count4 = Order::where('order_status','Working')->where('user_id',Auth()->user()->id)->count(); 
    //         $count5 = Order::where('order_status','Complete')->where('user_id',Auth()->user()->id)->count(); 
    //         $count6 = Order::where('order_status','Canceled')->where('user_id',Auth()->user()->id)->count(); 
    //         $orders = Order::with('orderService')->with('orderClient')->with('orderTeam')->where('order_status','!=','unpaid')->where('user_id',Auth()->user()->id)->latest()->paginate(10);
    //         $users = User::where('account_role',2)->get(); 
    //         $services = Service::where('is_active',1)->get();
    //         return  response()->json(compact('count1','count2','count3','count4','count5','count6','orders','users','services'), 200);

    //     } else {
    //         $count1 = Order::where('order_status','!=','unpaid')->count(); 
    //         $count2 = Order::where('order_status','Pending')->count(); 
    //         $count3 = Order::where('order_status','Submitted')->count(); 
    //         $count4 = Order::where('order_status','Working')->count(); 
    //         $count5 = Order::where('order_status','Complete')->count(); 
    //         $count6 = Order::where('order_status','Canceled')->count(); 
    //         $orders = Order::with('orderService')->with('orderClient')->with('orderTeam')->where('order_status','!=','unpaid')->latest()->paginate(10);
    //         $users = User::where('account_role',2)->get(); 
    //         $services = Service::where('is_active',1)->get();
    //         return  response()->json(compact('count1','count2','count3','count4','count5','count6','orders','users','services'), 200);

    //     }
    // }

    public function index()
    {
        
        if(Auth()->user()->account_role == 2) {
            $count1 = Order::where('order_status','!=','unpaid')->where('user_id',Auth()->user()->id)->count(); 
            $count2 = Order::where('order_status','Pending')->where('user_id',Auth()->user()->id)->count(); 
            $count3 = Order::where('order_status','Submitted')->where('user_id',Auth()->user()->id)->count(); 
            $count4 = Order::where('order_status','Working')->where('user_id',Auth()->user()->id)->count(); 
            $count5 = Order::where('order_status','Complete')->where('user_id',Auth()->user()->id)->count(); 
            $count6 = Order::where('order_status','Canceled')->where('user_id',Auth()->user()->id)->count(); 

            $orders = Order::with('orderService')->with('orderClient')->with('orderTeam')->where('order_status','!=','unpaid')->where('user_id',Auth()->user()->id)->latest()->paginate(10);
            return  response()->json(compact('count1','count2','count3','count4','count5','count6','orders'), 200);

        } else {
            $count1 = Order::where('order_status','!=','unpaid')->count(); 
            $count2 = Order::where('order_status','Pending')->count(); 
            $count3 = Order::where('order_status','Submitted')->count(); 
            $count4 = Order::where('order_status','Working')->count(); 
            $count5 = Order::where('order_status','Complete')->count(); 
            $count6 = Order::where('order_status','Canceled')->count(); 
            $orders = Order::with('orderService')->with('orderClient')->with('orderTeam')->where('order_status','!=','unpaid')->latest()->paginate(10);
            return  response()->json(compact('count1','count2','count3','count4','count5','count6','orders'), 200);

        }
    }

    //pending order
    public function pending() 
    {
        if(Auth()->user()->account_role == 2) {

            $orderData = Order::with('orderService')
                            ->with('orderClient')
                            ->with('orderTeam')
                            ->where('order_status','Pending')
                            ->where('user_id',Auth()->user()->id)
                            ->latest()
                            ->paginate(10);
            return  response()->json(compact('orderData'), 200);


        } else {
            $orderData = Order::with('orderService')
                            ->with('orderClient')
                            ->with('orderTeam')
                            ->where('order_status','Pending')
                            ->latest()
                            ->paginate(10);

            return  response()->json(compact('orderData'), 200);

        }
    }


    //submitted order
    public function submitted() 
    {
        if(Auth()->user()->account_role == 2) {

            $orderData = Order::with('orderService')
                            ->with('orderClient')
                            ->with('orderTeam')
                            ->where('order_status','Submitted')
                            ->where('user_id',Auth()->user()->id)
                            ->latest()
                            ->paginate(10);
            return  response()->json(compact('orderData'), 200);

        } else {
            $orderData = Order::with('orderService')
                            ->with('orderClient')
                            ->with('orderTeam')
                            ->where('order_status','Submitted')
                            ->latest()
                            ->paginate(10);

            return  response()->json(compact('orderData'), 200);

        }
    }

    //submitted order
    public function working() 
    {
        if(Auth()->user()->account_role == 2) {

            $orderData = Order::with('orderService')
                            ->with('orderClient')
                            ->with('orderTeam')
                            ->where('order_status','Working')
                            ->where('user_id',Auth()->user()->id)
                            ->latest()
                            ->paginate(10);
            return  response()->json(compact('orderData'), 200);

        } else {
            $orderData = Order::with('orderService')
                            ->with('orderClient')
                            ->with('orderTeam')
                            ->where('order_status','Working')
                            ->latest()
                            ->paginate(10);

            return  response()->json(compact('orderData'), 200);

        }
    }

    //Complete order
    public function complete() 
    {
        if(Auth()->user()->account_role == 2) {

            $orderData = Order::with('orderService')
                            ->with('orderClient')
                            ->with('orderTeam')
                            ->where('order_status','Complete')
                            ->where('user_id',Auth()->user()->id)
                            ->latest()
                            ->paginate(10);
            return  response()->json(compact('orderData'), 200);

        } else {

            $orderData = Order::with('orderService')
                            ->with('orderClient')
                            ->with('orderTeam')
                            ->where('order_status','Complete')
                            ->latest()
                            ->paginate(10);
            return  response()->json(compact('orderData'), 200);

        }
    }

    //Complete order
    public function canceled() 
    {
        if(Auth()->user()->account_role == 2) {

            $orderData = Order::with('orderService')
                            ->with('orderClient')
                            ->with('orderTeam')
                            ->where('order_status','Canceled')
                            ->where('user_id',Auth()->user()->id)
                            ->latest()
                            ->paginate(10);
            return  response()->json(compact('orderData'), 200);

        } else {

            $orderData = Order::with('orderService')
                            ->with('orderClient')
                            ->with('orderTeam')
                            ->where('order_status','Canceled')
                            ->latest()
                            ->paginate(10);
            return  response()->json(compact('orderData'), 200);

        }
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

           // $user->notify(new InvoicePaid($invoice));
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
            $user = User::find($team);
            $user->notify(new OrderAssign($order));
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
        if(Auth()->user()->account_role == 2) {
            /*
            * For Client
            */
            $order = Order::with('orderClient')->with('orderService')->where('user_id', Auth()->user()->id)->where('order_number', $order_number)->firstOrfail();
            $tags = Tag::all();
            return  response()->json(compact('order','tags'), 200);

        } else {
            /*
            * For admin
            */
            $order = Order::with('orderClient')->with('orderService')->with('orderForm')->with('invoice')->with('orderTeam')->where('order_number', $order_number)->firstOrfail();
            $teamMembers = User::where('account_role', 0)->orWhere('account_role',1)->get();
            $matchThese = ['order_id' => $order->id, 'user_id' => auth('api')->id()];
            $followOrUnfollow = OrderUnfollow::where($matchThese)->first();
            $tags = Tag::all();
            $order_tag = OrderTag::with('orderTag')->where('order_id',$order->id)->get();
            $user =  Auth::user();
            return  response()->json(compact('order', 'teamMembers', 'followOrUnfollow','tags','order_tag','user'), 200);
        }
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
    public function edit($order_number)
    {
        //
            $order = Order::with('orderClient')->with('orderService')->with('invoice')->where('order_number', $order_number)->firstOrfail();
            $users = User::where('account_role',2)->get(); 
            $services = Service::where('is_active',1)->get();

            return  response()->json(compact('order', 'users', 'services'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $order_number)
    {
        //update order table
        $order = Order::where('order_number',$order_number)->first();
        $order->update([
            'created_at' => $request->created_at,
            'strated_at' => $request->started_at,
            'completed_at' => $request->completed_at,
            'service_id' => $request->service['id'] ? $request->service['id'] : $order->service_id,
            'user_id' => $request->client['id'] ? $request->client['id'] : $order->user_id,
        ]);

            
        // Update invoice table
        $invoice = Invoice::where('order_id',$order->id)->first();
        $service_price = Service::select('price')->find($request->service['id']);
        if(!empty($invoice) && !empty($request->due_date)){

            if(!empty($request->service['id'])) {
                $invoiceTotal = $service_price->price * $order->quantity;
            } else {
                $invoiceTotal = $invoice->invoice_total;
            }

            $invoice->update([
                'user_id' => $request->client['id'],
                'invoice_total' => $invoiceTotal,
                'invoice_discount' => $invoiceTotal < $invoice->invoice_discount ? 0 : $invoice->invoice_discount,
                'due_date' => $request->due_date,
            ]);
        }

        // Update invoice item
        if($invoice) {
            $invoiceItem = InvoiceItem::where('invoice_id',$invoice->id)->first();
            if(!empty($invoiceItem)){
                $invoiceItem->update([
                    'service_id' => $request->service['id']
                ]);
            }  
        }



        return ['Order Updated Successfuly.'];
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
