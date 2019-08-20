<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

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
        return view('home');
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
