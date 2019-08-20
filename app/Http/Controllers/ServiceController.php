<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Service;

use App\ServiceVariant;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('services.create');
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

            'serviceName'=>'required|max:255',
            'description' =>'string|min:10',
            'price' =>'required|numeric|min:0',
            'serviceThumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            //'numOfDeadline' => 'integer|min:0|max:255',

        ]);

        if(!empty($request->serviceThumbnail))
        {
            $serviceThumbnail = $request->serviceName.rand(1,10).'.'.$request->serviceThumbnail->getClientOriginalExtension();
            $request->serviceThumbnail->move(public_path('uploads/service_pic'), $serviceThumbnail);
        }

        $service = Service::create([
            'name' => $request->serviceName,
            'description' => $request->description,
            'price' => $request->price,
            'thumbnail' => $serviceThumbnail,
            'display' => $request->showinServicePage,
            'requirments' => $request->serviceRequirments,
            'deadline' => $request->deadline,
            'deadline_number' => $request->numOfDeadline,
            'deadline_type' => $request->deadlineType,
        ]);

        $variantNames = $request->variantName;
        $variantValues = $request->variantValues;

        foreach ($variantNames as $key => $variantName) 
        {
            if(!empty($variantName))
            {
                foreach ($variantValues[$key] as $varientKey => $varientvalue) 
                {
                    $serviceVarient = ServiceVariant::create([
                        'service_id' => $service->id,
                        'variant_name' => $variantName,
                        'variant_value' => $varientvalue,
                    ]);
                }
            }
            
        }


        return redirect()->route('service.index')->with('success', 'Service Added');



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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $service = Service::where('slug', $slug)->firstOrFail();
        $service->delete();

    }
}
