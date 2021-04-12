<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaigns;
use App\Models\Donations;
use App\Models\Settings;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Log;
class DonationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Donations = Donations::all();
        return response()->json( $Donations );
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
        $columns =  Schema::getColumnListing('donations');
       
        $subdomain = $request->subdomain;

        // $check_subdomain = Settings::where('value', '=', $subdomain)->first();
        // if($check_subdomain != null){

            $data = $request->all();

            Log::channel('customlog')->info(json_encode($data));

            $data['donor_full_name'] = $request->donor_first_name.' '.$request->donor_last_name;
            $validator = Validator::make($data, [
                'subdomain' => 'required|max:255',
                'cause_id' => 'required|max:255',
                'cause_slug' => 'required|max:255',
                'cause_name' => 'required|max:255',
            ]);
            if ($validator->fails()) {
                return response(['error' => $validator->errors(), 'Validation Error']);
            }
            $getCampaigns = Campaigns::where('cause_id', '=', $request->cause_id)->first();
            if ($getCampaigns === null) { // campaigns does not exist
                $campaigns = Campaigns::create($data); //create campaign
                $Donations = Donations::create($data); // create donations
                $add_campaign_Tosheet =app('App\Http\Controllers\GsheetController')->addNewGsheet($data,$columns);

               
                return response()->json(['donations' => $Donations, 'message' =>'Created successfully'], 201);
            
            
            }else{  // campaigns exist
                $campaigns = Campaigns::find($getCampaigns->id);
                $campaigns->update($request->all()); // update campaign


                $getDonations=Donations::where('donation_id', '=',$request->donation_id)->where('cause_id', '=', $request->cause_id)->first();
                if ($getDonations === null) {

                    $donations = Donations::create($data);
                }else{
                     $donations = Donations::find($getDonations->id);
                     // $data['sheet_updated'] = 0; 
                     $request->request->add(['sheet_updated' => 0]); 
                     // $request->put('sheet_updated', 0);
                    
                     $donations->update($request->all()); // update donations
                }
                $update_campaign_Tosheet =app('App\Http\Controllers\GsheetController')->updateGSheet($campaigns->google_sheet_id,$campaigns->cause_id,$columns);
                return response()->json(['donations' => $donations, 'message' =>'Created successfully'], 201);

            }
            // $Campaigns = Campaigns::updateOrCreate($data);
           
        //  }
        // else{
        //     return response()->json(['message'=>'Subdomain does not match']);
        // }
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
        //  return response()->json(['message' => 'Id not Found']);
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
