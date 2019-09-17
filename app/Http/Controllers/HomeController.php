<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Invoice;
use App\Service;
use DB;

use App\Order;

use App\OrderMessage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth()->user()->account_role == 2) {

            $totalSpent = Invoice::where('user_id',auth()->user()->id)->sum('invoice_total');
            $totalOrders = Order::where('user_id',auth()->user()->id)->count();
            $unpaidOrders = Order::where('user_id',auth()->user()->id)->where('payment_staus','Not paid')->count();
            $totalRunningOrder = Order::where('user_id',auth()->user()->id)->where('order_status','Working')->count();
            return view('client-home',compact('totalSpent','totalOrders','unpaidOrders','totalRunningOrder'));

        } else {
            
            $totalSales = Invoice::sum('invoice_total');

            //Current month sales
            $currentMonth = date('m');
            $thisMonthSales = Invoice::whereRaw('MONTH(created_at) = ?',[$currentMonth])
                ->where('invoice_status','paid')
                ->sum('invoice_total');


            $totalOrders = Order::count();
            $unpaidOrders = Order::where('payment_staus','Not paid')->count();

            //Current month total order
            $thisMonthOrders =Order::whereRaw('MONTH(created_at) = ?',[$currentMonth])->count();

            $totalClients = User::where('account_role',2)->count();
            $totalTeam = User::where('account_role',0)->count();
            $totalServices = Service::count();
            $totalRunningOrder = Order::where('order_status','Working')->count();

            return view('home', compact('totalSales','thisMonthSales','totalOrders','unpaidOrders','thisMonthOrders','totalClients','totalTeam','totalServices','totalRunningOrder'));
        }
    }



    /**
     * Access user account.
     *
     * @param  string  $email
     * @return team home page
     */
    public function accessAccount(Request $request)
    {
        
        $email = $request->email;
        $user = User::where('email', $email)->firstOrFail();
        session()->put('hasClonedUser', auth()->user()->id);
        auth()->loginUsingId($user->id);
        return redirect()->route('home');
    }


    // Back to the main account
    public function backToAccount(Request $request)
    {

        $user = User::findOrFail(session()->get('hasClonedUser'));
        if($user->isAdmin())
        {
            auth()->loginUsingId(session()->remove('hasClonedUser'));
            session()->remove('hasClonedUser');
            return redirect()->route('home');
        }

        return redirect()->back();
    }



    // update order message
    public function orderMessageUpdate(Request $request)
    {
        // error message need to be cahnge soon
        $request->validate([
            'orderMessage' => 'required|string|min:9',
        ]);

        $order = Order::where('order_number', $request->orderNumber)->firstOrFail();

        $orderMessage = OrderMessage::create([

            'order_id' => $order->id,
            'sender_id' => auth()->user()->id,
            'message_body' => $request->orderMessage,
            'message_for' => $request->sendTo,
            'message_link' => '2',
            'read_at' => '2019-03-22 00:00:00'

        ]);
        
        $orderMessage->save();

        return redirect()->back()->with('success', 'Message updated successfully');
    }
}
