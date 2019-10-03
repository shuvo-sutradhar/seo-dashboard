<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;
use App\ServiceData;

class ServiceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth:api');
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Service::where('service_type','!=',null)->latest()->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $services = Service::all();
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
        //
        $this->validate($request, [

            'name' => 'required|string|unique:services,name|max:255',
            'one_time_price' => "required_if:service_type,==,1",
            'recurring_price' => "required_if:service_type,==,2",

        ]);
        

        /*
        *   Inser service data
        */
        $input['name'] = $request->name;
        $input['description'] = $request->description;

        if($request->thumbnail_img){
            $name = time().'.' . explode('/', explode(':', substr($request->thumbnail_img, 0, strpos($request->thumbnail_img, ';')))[1])[1];
            \Image::make($request->thumbnail_img)->save(public_path('uploads/service_pic/').$name);
            $input['thumbnail']      = $name;
        }

        $input['service_type'] = $request->service_type;
        $input['price'] = $request->service_type==1 ? $request->one_time_price : $request->recurring_price;
        $input['recurring_duration'] = $request->service_type==2 ? $request->recurring_duration : null;
        $input['recurring_for'] = $request->service_type==2 ? $request->recurring_for : null;
        $input['deadline'] = $request->isSetDeadline==true ? $request->deadline .' '. $request->deadline_type : null;
        $input['is_active'] = $request->is_active;
        $service = Service::create($input);

        return  response()->json(compact('service'), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        //
        return Service::where('slug',$slug)->with('variants')->first();

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
    public function update(Request $request, $slug)
    {

        $service = Service::where('slug',$slug)->first();
        //
        $this->validate($request, [

            'name' => 'required|string|max:191|unique:services,name,'.$service->id,
            'one_time_price' => "required_if:service_type,==,1",
            'recurring_price' => "required_if:service_type,==,2",

        ]);
        

        /*
        *   update service data
        */
        $service['name'] = $request->name;
        $service['description'] = $request->description;
        
        //Upload image if request for image
        $currentPhoto = $service->thumbnail;
        if($request->thumbnail_img != $currentPhoto){
            $name = time().'.' . explode('/', explode(':', substr($request->thumbnail_img, 0, strpos($request->thumbnail_img, ';')))[1])[1];
            \Image::make($request->thumbnail_img)->save(public_path('uploads/service_pic/').$name);
            $service['thumbnail']  = $name;
            $userPhoto = public_path('uploads/service_pic/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }

        $service['service_type'] = $request->service_type;
        $service['price'] = $request->service_type==1 ? $request->one_time_price : $request->recurring_price;
        $service['recurring_duration'] = $request->service_type==2 ? $request->recurring_duration : null;
        $service['recurring_for'] = $request->service_type==2 ? $request->recurring_for : null;
        $service['deadline'] = $request->isSetDeadline==true ? $request->deadline .' '. $request->deadline_type : null;
        $service['is_active'] = $request->is_active;
        $service->save();

        return ['message' => 'Service updated successfuly.'];
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
        $service = Service::findOrFail($id);

        $currentPhoto = $service->thumbnail;
        if($currentPhoto){
            $userPhoto = public_path('uploads/service_pic/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }
        $service->delete();

        return ['message' => 'User Deleted'];
    }

    /*
    *   Duplicate row
    */
    public function duplicate($id)
    {
        //
        $service = Service::find($id);
        $newService = $service->replicate();
        $newService['name'] = $service->name."(copy)";
        $newService->save();
        return ['message' => 'Service Duplicate Successfuly'];
    }

    /*
    *   Duplicate row
    */
    public function dataField(Request $request, $slug) 
    {

        //
        // dd($request->all());
        $service = Service::where('slug',$slug)->pluck('id');
        $serviceData = ServiceData::where('service_id',$service[0])->first();
        //return $serviceData;


        if(!$serviceData){
            $serviceData = new ServiceData;
            $serviceData->service_id = $service[0];
        }

        $serviceData->dataForm = json_encode($request->form);
        $serviceData->save();

        return ['Service data added successfuly.'];
    }


    /*
    *   Get data field
    */
    public function getDataField($slug)
    {
        $service = Service::where('slug',$slug)->pluck('id');
        return ServiceData::where('service_id',$service[0])->first();

    }


    /*
    *   Delete service data
    */
    public function dataFieldDelete($id)
    {
        return ServiceData::destroy($id);
    }
}
