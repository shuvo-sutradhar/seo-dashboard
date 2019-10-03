<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;
use App\OrderForm;
use DB;



class OrderFormController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //
    //     return OrderForm::latest()->paginate(10);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $services = Service::where('is_active',1)->get();
        return  response()->json(compact('services'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'formName' => 'required|string|max:191'
        ]);

        $input['formName'] = $request->formName; 
        $input['formLink'] = str_random(10); 
        $input['formInfo'] = $request->formInfo; 
        $input['cuponCode'] = $request->cuponCode; 
        $input['orderForm'] = json_encode($request->form); 

        $order = OrderForm::create($input);
        //return $order;
        return  response()->json(compact('order'), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $input = OrderForm::findOrFail($id);
        //
        $input['formName']  = $request->formName; 
        $input['formLink']  = $request->formLink; 
        $input['formInfo']  = $request->formInfo; 
        $input['cuponCode'] = $request->cuponCode; 
        $input['orderForm'] = json_encode($request->form); 

        $input->update();

        return ['message'=>'Form has been updated successfully.'];
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
        $department = OrderForm::where('formLink',$id)->first();
        // delete the user
        $department->delete();
        return $department;
    }
    //change status
    public function status($id, $status) {

        DB::table('order_forms')
            ->where('id', $id)
            ->update(['status' => $status]);

        return redirect()->back();
    }

    //duplicate 
    public function duplicate($id) {
        $form = OrderForm::find($id);
       

        if(strpos($form->formName, 'copy')){
            $input['formName'] = $form->formName; 
        } else {
            $input['formName'] = $form->formName . "(copy)"; 
        }
        $input['formLink'] = str_random(10); 
        $input['formInfo'] = $form->formInfo; 
        $input['cuponCode'] = $form->cuponCode; 
        $input['orderForm'] = $form->orderForm; 
        $input['status'] = $form->status; 

        OrderForm::create($input);
        // return ['message'=>'Row duplicate successfully.'];
    }


}
