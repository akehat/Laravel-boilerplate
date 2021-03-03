<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaigns;
use DB;

class CampaignsController extends Controller
{
    public function index()
    {
    	$status = 'all';
        return view('campaigns.campaigns', compact('status'));
    }
    public function active()
    {
	    $status = 1;
        return view('campaigns.campaigns', compact('status'));
    }
    public function status( $campaign_id, $status)
    {
    	$save_status= array(
          'status' => $status        
        );

    	$update_Campaign =  DB::table('campaigns')->where('id',$campaign_id)->update($save_status);
    	return redirect()->route('admin.campaigns.index')->withFlashSuccess(__('The Campaign was successfully updated.'));
    }
    public function archive()
    {
    	$status = 2;
        return view('campaigns.campaigns', compact('status'));
    }   
}
