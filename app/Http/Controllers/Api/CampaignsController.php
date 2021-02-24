<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaigns;
use App\Models\Settings;
use Illuminate\Support\Facades\Validator;

class CampaignsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = Campaigns::all();
        return response()->json( $campaigns );
        // return 
        // echo "<pre>";print_r($campaigns);die;
        // return view('campaigns');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subdomain = $request->subdomain;
        $check_subdomain = Settings::where('value', '=', $subdomain)->first();
        if($check_subdomain != null){

            $data = $request->all();
            $validator = Validator::make($data, [
                'subdomain' => 'required|max:255',
                'cause_id' => 'required|max:255',
                'cause_slug' => 'required|max:255',
                'cause_name' => 'required|max:255',
                // 'client_id' => 'string|max:255|nullable'
            ]);

            if ($validator->fails()) {
                return response(['error' => $validator->errors(), 'Validation Error']);
            }
            $getCampaigns = Campaigns::where('cause_name', '=', $request->cause_name)->first();
            // echo "<pre>";print_r($getCampaigns->id);die;
            if ($getCampaigns === null) {
                $campaigns = Campaigns::create($data);
               // user doesn't exist
            }else{
                $campaigns = Campaigns::find($getCampaigns->id);
                $campaigns->update($request->all());
            }
            // $Campaigns = Campaigns::updateOrCreate($data);
           

            return response()->json(['campaigns' => $campaigns, 'message' =>'Created successfully'], 201);
         }
        else{
            return response()->json(['message'=>'Subdomain does not match']);
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
    	$campaigns = Campaigns::find($id);
      
        if($campaigns){
           return response()->json( ['campaigns' => $campaigns, 'message' => 'Retrieved successfully' ]);
        }else{
        	return response()->json(['message' => 'Id not Found']);
        }

       
        // return response(['campaigns' => $campaigns, 'message' => 'Retrieved successfully'], 200);
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

        $subdomain = $request->subdomain;
        $check_subdomain = Settings::where('value', '=', $subdomain)->first();
        if($check_subdomain != null){

            $data = $request->all();
            $validator = Validator::make($data, [
                'subdomain' => 'required|max:255',
                'cause_id' => 'required|max:255',
                'cause_slug' => 'required|max:255',
                'cause_name' => 'required|max:255',
                // 'client_id' => 'string|max:255|nullable'
            ]);

            if ($validator->fails()) {
                return response(['error' => $validator->errors(), 'Validation Error']);
            }
            $campaigns = Campaigns::find($id);
            if($campaigns){
                $campaigns->update($request->all());
                return response()->json(['campaigns' =>$campaigns,'message'=>'Update successfully']);
            }else{
                 $campaigns = Campaigns::create($data);

                return response()->json(['campaigns' => $campaigns, 'message' =>'Created successfully'], 201);
            }
          
           

         }
        else{
            return response()->json(['message'=>'Subdomain does not match']);
        }

    	// $campaigns = Campaigns::find($id);
      
     //    if($campaigns){
	    //     $campaigns->update($request->all());
     //        return response()->json(['campaigns' =>$campaigns,'message'=>'Update successfully']);
    	// }else{
    	// 	return response()->json(['message' => 'Id not Found']);
    	// }
       
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $campaigns = Campaigns::find($id);
      
        if($campaigns){
         $campaigns->delete();

         return response()->json(['message' => 'Deleted']);
        }else{
        	return response()->json(['message' => 'Id not Found']);
        }
    }
}
