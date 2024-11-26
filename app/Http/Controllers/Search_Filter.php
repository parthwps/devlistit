<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caterogries_Search_Filters;

class Search_Filter extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

     public function test()
    {
       // this will display all the record where vendor_id matched
        $data = Caterogries_Search_Filters::where('vendor_id',13)->get(['search_filters']);

        //

        dd($data);
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        
         
        $data = [
             'vendor_id' => 13,
               'title' => $request->title,
                 'search_alerts' => $request->optradio,
            'search_filters' => json_encode([
                'category' => $request->category,
                'location' => $request->location,
                'prices' => [
                  'prices_min' => $request->prices_min,
                    'prices_max' => $request->prices_max,
                ],
                 'brands' => $request->brands,
                'models' => $request->models,
                'year' => [
                    'year_min' =>$request->year_min,
                     'year_max' =>$request->year_max,

            ],
                 'mileage' => [
                             'mileage_min' =>$request->mileage_min,
                              'mileage_max' =>$request->mileage_max,
                               ],
                'fuel_type' => $request->fuel_type,
                'engine' => [ 'engine_min'=> $request->engine_min,
                       'engine_max'=> $request->engine_max,
            ],
                 'power' => [ 
                    'power_min' => $request->power_min,
                     'power_max' => $request->power_max,

             ],
                'battery' => $request->battery,
                'condition' => $request->condition,
                 'owners' => $request->owners,
                'doors' => $request->doors,
                'seats' => [ 
                    'seat_min' =>$request->seat_min,
                      'seat_max' =>$request->seat_max,
 ]

            ] ),
        ];


Caterogries_Search_Filters::create($data);


        return response()->json([
          'message' => "Your Search is saved Successfully",
         
        ]);


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
    }
}
