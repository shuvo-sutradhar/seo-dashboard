<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Order;

use App\OrderMessage;

use App\User;

use App\OrderUnfollow;

use App\Tag;

use App\OrderTag;

class OrderController extends Controller
{    

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $orders = Order::latest()->paginate(10);
        return view('orders.index', compact('orders'));
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
    public function show($number)
    {
        $order = Order::where('order_number', $number)->firstOrfail();
        $teamMembers = User::where('account_role', 0)->get();
        $matchThese = ['order_id' => $order->id, 'user_id' => auth()->user()->id];
        $followOrUnfollow = OrderUnfollow::where($matchThese)->first();
        $tags = Tag::all();
        return view('orders.details', compact('order', 'teamMembers', 'followOrUnfollow', 'tags'));
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





    // update order note
    public function updateOrderNote(Request $request, $number)
    {
        $request->validate([
            'orderNote' => 'required|string',
        ]);
        

        $order = Order::where('order_number', $number)->firstOrFail();

        $orderUpdate = $order->update([

            'order_note' => $request->orderNote,
        ]);

        return redirect()->back()->with('success', 'Note updated successfully');
    }


    // delete order message
    public function deleteMessage($id)
    {
        $message = OrderMessage::findOrFail($id);
        //dd($message);
        $message->delete();
    }

    // order status
    public function orderStatus(Request $request, $number)
    {
        $order = Order::where('order_number', $number)->firstOrFail();

        $order->update([
            'order_status' => $request->status

        ]);

        return redirect()->back()->with('success', 'Order status has been changed');
    }

    // assign order
    public function assignOrders(Request $request, $number)
    {
        $order = Order::where('order_number', $number)->firstOrFail();

        if($request->teamMember == 'anyone')
        {
            $team = null;
        }
        else
        {
            $team = $request->teamMember;
        }
        $order->update([
            'team_member_id' => $team
        ]);

        return redirect()->back()->with('success', 'Order has been assign');
    }


    // follow or unflow order
    public function orderFollow($number)
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
                return redirect()->back()->with('success', 'You are now following the order');
            }
            return redirect()->back()->with('success', 'You are now unfollowing the order');
        }
        else
        {
            OrderUnfollow::create([
                'order_id' => $order->id,
                'user_id' => auth()->user()->id,
                'is_following' => 1,

            ]);
        }

        return redirect()->back()->with('success', 'You are now following the order');
    }

    public function assignTags()
    {
        OrderTag::create([

        ]);
    }


}
