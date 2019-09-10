<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Discount;
use App\Service;
use App\DiscountService;

class DiscountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Discount::all();
    }

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
        //
        //dd($request->items[0]['discount_amount']);
        $this->validate($request, [
            'cupon_code' => 'required|string|max:191|unique:discounts',
            'discount_type' => 'required',
            'discount_duration' => 'required',
            'discount' => 'numeric',
        ]);

        $discount  = Discount::create([
            'cupon_code' => $request->cupon_code,
            'description' => $request->description,
            'discount_type' => $request->discount_type,
            'discount_duration' => $request->discount_duration,
            'limit_1' => $request->limit_1,
            'total_limit' => $request->is_total_limit ? $request->total_limit : null,
            'expiry_date' => $request->is_expiry_date ? $request->expiry_date : null,
            'is_active' => $request->isactive,
        ]);


        if(count($request->items) == 1) {
            $discount_service = DiscountService::create([
                'discount_id' => $discount->id,
                'service_id' => $request->items[0]['selectedService'],
                'discount_amount' => $request->items[0]['discount_amount']
            ]);
        } else  {
            foreach($request->items as $key){
                if(!is_null($key['selectedService']) && !is_null($key['discount_amount'])) {
                    $discount_service = DiscountService::create([
                        'discount_id' => $discount->id,
                        'service_id' => $key['selectedService']['id'],
                        'discount_amount' => $key['discount_amount']
                    ]);
                }
            }
        }
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
    public function destroy($id)
    {
        //
        return Discount::destroy($id);
    }
}
