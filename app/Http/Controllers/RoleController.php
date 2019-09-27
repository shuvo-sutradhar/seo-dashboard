<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Alert;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('account.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
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

            'name'=>'required|unique:roles|max:30',
            'permissions' =>'required',

        ]);

        $role = new Role();
        $role->name = $request->name;
        $role->save();


        foreach ($request->permissions as $permission) 
        {
            $selectedPermission = Permission::where('id', '=', $permission)->firstOrFail(); 

            //Fetch the newly created role and assign permission
            $role = Role::where('name', '=', $request->name)->first(); 
            $role->givePermissionTo($selectedPermission);
        }

        Alert::success('Success Message', 'Role ' . $role->name .' added')->autoclose(3000);
        return redirect()->route('account.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('account.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
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
        
        // Get role   
        $role = Role::findOrFail($id);

        $request->validate([

            'name'=>'required|max:10|unique:roles,name,'.$role->id,
            'permissions' =>'required',
        ]);


        $permissions = $request['permissions'];
        $role->fill($request->except(['permissions']))->save();

        //Get all permissions
        $allPermissions = Permission::all();

        foreach ($allPermissions as $permission) 
        {
            //Remove all permissions associated with role
            $role->revokePermissionTo($permission); 
        }

        foreach ($permissions as $permission) 
        {
            //Get corresponding form //permission in db
            $newPermission = Permission::where('id', '=', $permission)->firstOrFail(); 

            //Assign permission to role
            $role->givePermissionTo($newPermission);  
        }

        // return redirect()->route('account.index')->with('success', 'Role updated successfully');
        return redirect()->back()->with('success', 'Role updated successfully');
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
}
