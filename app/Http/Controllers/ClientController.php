<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Rules\PhoneNumber;

use App\User;

use App\Client;

use Spatie\Permission\Models\Role; 

use Illuminate\Support\Facades\Hash;

use File;

use Alert;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('clients.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $request->validate([

            'clientName' => 'required|string|max:255|min:3',
            'clientEmail' =>'required|string|email|unique:users,email|max:255',
            'clientPhone' =>'nullable|numeric|min:0',
            'profilePicture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'nullable|string|max:255|min:3',
            'city' => 'nullable|string|max:255|min:3',
            'country' => 'nullable|string|max:255|min:2',
            'state' => 'nullable|string|max:255|min:3',
            'postalCode' => 'nullable|string|max:255|min:3',
            'companyName' => 'nullable|string|max:255|min:2',
            'taxID' => 'nullable|string|max:255|min:2',
            'password' => 'required|min:6',

        ]);


        $user = User::create([

            'name' => $request->clientName,
            'email' => $request->clientEmail,
            'password' => Hash::make($request->password),
            'account_role' => 2

        ]);

        $profilePicture = '';
        if($request->profilePicture)
        {
            $profilePicture = $user->name.rand(1,10).'.'.$request->profilePicture->getClientOriginalExtension();
            $request->profilePicture->move(public_path('uploads/profile_pic'), $profilePicture);
        }

        $client = Client::create([

            'user_id' => $user->id,
            'phone' => $request->clientPhone,
            'profile_picture' => $profilePicture,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'state' => $request->state,
            'post_code' => $request->postalCode,
            'company_name' => $request->companyName,
            'tax_id' => $request->taxID,

        ]);


        return redirect()->route('client.index')->with('success',  ' Client '. ucfirst($user->name) .' created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($email)
    {
        $user = User::where('email', $email)->firstOrfail();
        $orders = $user->orders()->latest()->paginate(5);
        $invoices = $user->clientInvoices()->latest()->paginate(5);
        $totalOrder = $user->orders()->count();
        $totalSpent = $user->clientInvoices()->sum('invoice_total');
        return view('clients.show', compact('user', 'orders', 'invoices','totalOrder','totalSpent'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($email)
    {
        return view('clients.edit');
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

        $user = User::where('email', $email)->firstOrFail();
      
        $request->validate([

            'clientEmail'=>'string|email|max:255|unique:users,email,'.$user->id,
            'clientName'=>'required|string|max:255',
            'clientPhone'=>['numeric', new PhoneNumber],
            'profilePicture' =>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' =>'string|max:255',
            'city' =>'string|max:255',
            'country' =>'string|max:30',
            'state' =>'string|max:255',
            'postalCode' =>'string|max:255',
            'companyName' =>'string|max:255',
            'taxID' =>'max:255',
            'password' => 'nullable|min:6|confirmed',

        ]);


        $user->name = $request['clientName'];
        $user->email = $user->email;
        if($request['password']) {
            $user->password = Hash::make($request['password']);
        }
        $user->save();



        
        $clientProfile = Client::where('user_id', $user->id)->first();
        $profilePic = null;

        // Delete user profile picture and set new profile picture
        if(!empty($request->profilePicture))
        {
            // Delete user profile picture   
            if(!empty($clientProfile) && !empty($clientProfile->profile_picture))
            {
                        
                $image_path = public_path('uploads/profile_pic'). "\\" .$clientProfile->profile_picture;
                if(File::exists($image_path)) 
                {
                    File::delete($image_path);
                } 
            }

            // Upload new profile picture  to the directory
            $profilePic = $request->clientName.rand(1,10).'.'.$request->profilePicture->getClientOriginalExtension();
            $request->profilePicture->move(public_path('uploads/profile_pic'), $profilePic);

        } else {
            if(!empty($clientProfile) && !empty($clientProfile->profile_picture)) {
                $profilePic = $clientProfile->profile_picture;
            }
        }

        // $clientProfileUpdate = $clientProfile->update([

        //         'phone' => $request->clientPhone,
        //         'profile_picture' => $profilePic,
        //         'address' => $request->address,
        //         'city' => $request->city,
        //         'country' => $request->country,
        //         'state' => $request->state,
        //         'post_code' => $request->postalCode,
        //         'company_name' => $request->companyName,
        //         'tax_id' => $request->taxID,

        // ]);

        //save data if not found in client table if found then update
        if(empty($clientProfile)) {
            $clientProfile = new Client;
            $clientProfile->user_id = $user->id;
        } 

        $clientProfile->phone = $request->clientPhone;
        $clientProfile->profile_picture = $profilePic;
        $clientProfile->address = $request->address;
        $clientProfile->city = $request->city;
        $clientProfile->country = $request->country;
        $clientProfile->state = $request->state;
        $clientProfile->post_code = $request->postalCode;
        $clientProfile->company_name = $request->companyName;
        $clientProfile->tax_id = $request->taxID;
        $clientProfile->save();

        return redirect()->route('client.index')->with('success',  ' Client '. ucfirst($request->clientName) .' updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($email)
    {
        $user = User::where('email', $email)->firstOrFail();

        // Delete user profile picture
        if($user->client && !is_null($user->client->profile_picture))
        {
            $image_path = public_path('uploads/profile_pic'). "\\" .$user->client->profile_picture ;
            if(File::exists($image_path)) 
            {
                File::delete($image_path);
            } 
        }

        $user->delete();
    
    }
}
