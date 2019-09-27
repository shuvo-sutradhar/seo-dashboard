<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Rules\PhoneNumber;

use Spatie\Permission\Models\Role; 

use Illuminate\Support\Facades\Hash;

use File;

use App\User;

use App\Profile;

use App\Notifications\WelcomeTeam;

use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::latest()->paginate(10);
        $users = User::where('account_role', 0)->latest()->paginate(10);
        return view('settings.team', compact('roles', 'users'));
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
            'password' => Hash::make($request->password)
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

            'email'=>'required|string|email|max:255|unique:users,email,'.$user->id,
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

            'email' => $request->email,
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
    public function profile_update(Request $request, $email){

        $user = User::where('email', $email)->firstOrFail();

        $request->validate([
            'name'=>'required|string|max:255',
        ]);
        
        if (isset($request['current_password']) && !Hash::check($request['current_password'], $user->password)) {
            return back()->with('current_password', 'The specified password does not match the database password');
        } else {
            // write code to update password
            return "Okay";

        }

        /*
        *   update user table
        */
        $user->name = $request['name'];
        $user->email = auth()->user()->email;
        if($request['password']) {
            $user->password = Hash::make($request['password']);
        }
        $user->save();

        return "Okay";
    }
}
