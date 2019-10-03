<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Rules\PhoneNumber;

use Spatie\Permission\Models\Role; 

use Illuminate\Support\Facades\Hash;

use File;

use App\User;
use App\Client;
use Carbon\Carbon;

use App\Profile;

use App\Notifications\WelcomeTeam;

use DB;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('account_role', 0)->latest()->paginate(10);
        return view('settings.team', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('accounts.create', compact('roles'));
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

            'email'=>'required|string|email|unique:users|max:255',
            'name'=>'required|string|max:255',
            'phone'=>['nullable', 'numeric', new PhoneNumber],
            'role' =>'required|integer',
            'profilePic' =>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required|min:6',

        ]);


        // Create user
        $user = User::create([

            'email' => $request->email,
            'name' => $request->name,
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' => Hash::make($request->password),
            'account_role' => 0

        ]);

        // Move profile picture to the directory
        $profilePic = '';
        if(!empty($request->profilePic))
        {
            $profilePic = $user->name.rand(1,10).'.'.$request->profilePic->getClientOriginalExtension();
            $request->profilePic->move(public_path('uploads/profile_pic'), $profilePic);
        }


        // Create profile for user
        $profile = Profile::create([

            'user_id' => $user->id,
            'contact_number' => $request->phone,
            'profile_picture' => $profilePic
        ]);


        // Assign role to user
        $user->assignRole($request->role);

    
        // Create activity log 
        activity()->performedOn($user)->causedBy(auth()->user())->log('Created team account for '. $user->name);

        // Send mail notification
        if(isset($request->mailNotification))
        {
            $user->setAttribute('realPassword', $request->password);
            $user->notify(new WelcomeTeam($user));
        }

        return redirect()->route('account.index')->with('success',  ' Team member'. ucfirst($user->name) .' added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($email)
    {
        $user = User::where('email', $email)->firstOrFail();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  strinf email
     * @return accounts.edit page
     */
    public function edit($email)
    {
        $roles = Role::all();
        $user = User::where('email', $email)->firstOrFail();
        return view('accounts.edit', compact('user', 'roles'));
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
        $userProfile = Profile::where('user_id', $user->id)->firstOrFail();
        
        $request->validate([

            'name'=>'required|string|max:255',
            'phone'=>['nullable', 'numeric', new PhoneNumber],
            'role' =>'required|integer',
            'profilePic' =>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'nullable|min:6',

        ]);

        
        $password = $user->password;
        // Set password
        if(!empty($request->changePassword) && !empty($request->password))
        {
            $password = Hash::make($request->password);
        }


        // Update password
        $userUpdate = $user->update([

            'email' => $email,
            'name' => $request->name,
            'password' => $password,

        ]);

        // Update user role
        if (!empty($request->role)) 
        {         
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();
            $user->assignRole($request->role);       
        }        



        $profilePic = $user->profile->profile_picture;

        // Delete user profile picture and set new profile picture
        if(!empty($request->profilePic))
        {
            
            // Delete user profile picture   
            if(!empty($user->profile->profile_picture))
            {
                        
                $image_path = public_path('uploads/profile_pic'). "\\" .$user->profile->profile_picture;
                if(File::exists($image_path)) 
                {
                    File::delete($image_path);
                } 
            }

            // Upload new profile picture  to the directory
            $profilePic = $request->name.rand(1,10).'.'.$request->profilePic->getClientOriginalExtension();
            $request->profilePic->move(public_path('uploads/profile_pic'), $profilePic);

        }


        // Update user profile
        $userProfileUpdate = $userProfile->update([
            'contact_number' => $request->phone,
            'profile_picture' => $profilePic

        ]);



        // Send mail notification
        if(isset($request->mailNotification))
        {
            $user->setAttribute('realPassword', $request->password);
            $user->notify(new WelcomeTeam($user));
        }

        return redirect()->route('account.index')->with('success',  ' Team member '. ucfirst($user->name) .' updated');
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
        if(!empty($user->profile->profile_picture))
        {
            $image_path = public_path('uploads/profile_pic'). "\\" .$user->profile->profile_picture;
            if(File::exists($image_path)) 
            {
                File::delete($image_path);
            } 
        }

        $user->delete();
    }


    //update login user profile
    public function profile(){
        return view('profile');
    }

    public function profile_update(Request $request,$email){
        /*
        *   Validation rules
        */
        if ($request->old_password && !(Hash::check($request->old_password, Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->withInput()->withErrors(['old_password'=> 'Current passowrd do not match with our record.']);
        }
        if ($request->password && Hash::check($request->password, Auth::user()->password)) {
            // The passwords matches
            return redirect()->back()->withInput()->withErrors(['password'=> 'Old password ane new password can not be same.']);
        }
        $this->validate($request, [
            'password' => 'sometimes|confirmed',
        ]);




        /*
        *   update user table
        */
        $user = Auth()->user();
        $user->name = $request['name'];
        $user->email = auth()->user()->email;
        if($request['password']) {
            $user->password = Hash::make($request['password']);
        }
        $user->save();
        /*
        *   Update profile table
        */


        if(Auth()->user()->account_role == 2){
            /*
            *   profile table data
            */
            $client = $user->client;
            $profile_picture = $client && $client->profile_picture ? $client->profile_picture : null;

            if($file = $request->file('profile_picture')){
                if($client && $client->profile_picture) {
                    unlink(public_path('uploads/profile_pic/'. $client->profile_picture));  
                }
                $name = time() . $request->profile_picture->getClientoriginalName();
                $file->move(public_path('uploads/profile_pic/'),$name);
                $profile_picture = $name;
            }

            //check if user tble is empty or not! If empty then set an user id
            if(empty($client)) {
                $client = new Client;
                $client->user_id = $user->id;
            } 

            $client->phone = $request->phone;
            $client->profile_picture = $profile_picture;
            $client->address = $request->address;
            $client->city = $request->city;
            $client->state = $request->state;
            $client->post_code = $request->post_code;
            $client->company_name = $request->company_name;
            $client->tax_id = $request->tax_id;
            $client->country_id = $request->input('country') != 'Select Country' ? $request->input('country') : null;
            $client->save();

        } else {
            /*
            *   profile table data
            */
            $profile = $user->profile;
            $profile_picture = $profile && $profile->profile_picture ? $profile->profile_picture : null;

            if($file = $request->file('profile_picture')){
                if($profile && $profile->profile_picture) {
                    unlink(public_path('uploads/profile_pic/'. $profile->profile_picture));  
                }
                $name = time() . $request->profile_picture->getClientoriginalName();
                $file->move(public_path('uploads/profile_pic/'),$name);
                $profile_picture = $name;
            }

            //check if user tble is empty or not! If empty then set an user id
            if(empty($profile)) {
                $profile = new Profile;
                $profile->user_id = $user->id;
            } 

            $profile->contact_number = $request->phone;
            $profile->profile_picture = $profile_picture;
            $profile->save();
        }

        return redirect()->back()->with("success","Profile updated successfully!");
    }
}
