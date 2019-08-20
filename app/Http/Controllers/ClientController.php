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
        
        $users = User::where('account_role', 2)->latest()->paginate(10);
        return view('clients.index', compact('users'));
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
        if(!empty($request->profilePicture))
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
        return view('clients.show', compact('user', 'orders', 'invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($email)
    {
        $user = User::where('email', $email)->firstOrfail();
        return view('clients.edit', compact('user'));
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
        $clientProfile = Client::where('user_id', $user->id)->firstOrFail();
        
        $request->validate([

            'clientEmail'=>'required|string|email|max:255|unique:users,email,'.$user->id,
            'clientName'=>'required|string|max:255',
            'clientPhone'=>['nullable', 'numeric', new PhoneNumber],
            'profilePicture' =>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' =>'string|max:255',
            'city' =>'string|max:255',
            'country' =>'string|max:30',
            'state' =>'string|max:255',
            'postalCode' =>'string|max:255',
            'companyName' =>'string|max:255',
            'taxID' =>'max:255',
            'password' => 'nullable|min:6',

        ]);



        $user->name = $request['clientName'];
        $user->email = $request['clientEmail'];

        if($request['password']) {
            $user->password = Hash::make($request['password']);
        }

        $user->save();



        $profilePic = $clientProfile->profile_picture;

        // Delete user profile picture and set new profile picture
        if(!empty($request->profilePicture))
        {
            // Delete user profile picture   
            if(!empty($profilePic))
            {
                        
                $image_path = public_path('uploads/profile_pic'). "\\" .$profilePic;
                if(File::exists($image_path)) 
                {
                    File::delete($image_path);
                } 
            }

            // Upload new profile picture  to the directory
            $profilePic = $request->clientName.rand(1,10).'.'.$request->profilePicture->getClientOriginalExtension();
            $request->profilePicture->move(public_path('uploads/profile_pic'), $profilePic);

        }


        $clientProfileUpdate = $clientProfile->update([
            'phone' => $request->clientPhone,
            'profile_picture' => $profilePic,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'state' => $request->state,
            'post_code' => $request->postalCode,
            'company_name' => $request->companyName,
            'tax_id' => $request->taxID,

        ]);

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
        $profilePic = $user->client->profile_picture;
        if(!empty($profilePic))
        {
            $image_path = public_path('uploads/profile_pic'). "\\" .$profilePic ;
            if(File::exists($image_path)) 
            {
                File::delete($image_path);
            } 
        }

        $user->delete();
    
    }
}
