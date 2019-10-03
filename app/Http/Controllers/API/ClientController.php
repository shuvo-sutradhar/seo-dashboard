<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Client;
use App\Country;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Notifications\WelcomeClient;

class ClientController extends Controller
{    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return User::where('account_role', 2)->with('client')->latest()->paginate(10);
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
        $this->validate($request, [

            'name' => 'required|string|max:255|min:3',
            'email' =>'required|string|email|unique:users,email|max:255',
            'phone' =>'nullable|numeric|min:0',
            'address' => 'nullable|string|max:255|min:3',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'companyName' => 'nullable|string|max:255|min:2',
            'taxID' => 'nullable|string|max:255|min:2',
            'password' => 'required|min:6',

        ]);

        //user insert into users table
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' => Hash::make($request->password),
            'account_role' => 2
        ]);

        //upload profile image
        if($request->profile_picture){
            $name = time().'.' . explode('/', explode(':', substr($request->profile_picture, 0, strpos($request->profile_picture, ';')))[1])[1];
            \Image::make($request->profile_picture)->save(public_path('uploads/profile_pic/').$name);
            $request->profile_picture     = $name;
        }


        //add client data
        $client = Client::create([

            'user_id' => $user->id,
            'phone' => $request->phone,
            'profile_picture' => $request->profile_picture,
            'address' => $request->address,
            'city' => $request->city,
            'country_id' => $request->country['id'],
            'state' => $request->state,
            'post_code' => $request->postal_code,
            'company_name' => $request->companyName,
            'tax_id' => $request->taxID,

        ]);

        //send mail is sendNotification==true
        if($request->emailNotification == true) {
            $user->setAttribute('realPassword', $request->password);
            $user->notify(new WelcomeClient($user));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAllCountry()
    {
        //
        return Country::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($email)
    {
        //
        $user = User::where('email', $email)->with('client.country')->firstOrfail();
        $orders = $user->orders()->with('orderService')->latest()->paginate(5);
        $invoices = $user->clientInvoices()->latest()->paginate(5);
        $totalOrder = $user->orders()->count();
        $totalSpent = $user->clientInvoices()->sum('invoice_total');
        return  response()->json(compact('user','orders','invoices','totalOrder','totalSpent'), 200);
    }


    public function edit($email) 
    {
        return User::where('email', $email)->with('client.country')->firstOrfail();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $email)
    {
        //
        $user =User::where('email', $email)->firstOrfail();
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id
        ]);



        /*
        *   update user table
        */
        $user->name = $request['name'];
        $user->email = $user->email;
        if($request['password']) {
            $user->password = Hash::make($request['password']);
        }
        $user->save();



        /*
        *   get client profile table data
        */
        $clientProfile = Client::where('user_id', $user->id)->first();


        /*
        *   CHeck user image
        */
        $currentPhoto = $clientProfile ? $clientProfile->profile_picture : null;
        
        if($request->profile_picture != $currentPhoto){
            $name = time().'.' . explode('/', explode(':', substr($request->profile_picture, 0, strpos($request->profile_picture, ';')))[1])[1];
            \Image::make($request->profile_picture)->save(public_path('uploads/profile_pic/').$name);
            $request->profile_picture     = $name;
            $userPhoto = public_path('uploads/profile_pic/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }

        //check if user tble is empty or not! If empty then set an user id
        if(empty($clientProfile)) {
            $clientProfile = new Client;
            $clientProfile->user_id = $user->id;
        } 

        $clientProfile->phone = $request->phone;
        $clientProfile->profile_picture = $request->profile_picture;
        $clientProfile->address = $request->address;
        $clientProfile->city = $request->city;
        $clientProfile->country_id = $request->country['id'];
        $clientProfile->state = $request->state;
        $clientProfile->post_code = $request->postCode;
        $clientProfile->company_name = $request->companyName;
        $clientProfile->tax_id = $request->taxId;
        $clientProfile->save();



        //send mail is sendNotification==true
        if($request->password && $request->emailNotification == true) {
            $user->setAttribute('realPassword', $request->password);
            $user->notify(new WelcomeClient($user));
        }

        return ['message' => "Success"];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = User::findOrFail($id);

        if($user->client && !is_null($user->client->profile_picture)){
            $userPhoto = public_path('uploads/profile_pic/').$user->client->profile_picture;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }

        $user->delete();
        return ['message' => 'User Deleted'];

    }
}
