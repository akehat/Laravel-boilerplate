<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaigns;

class CampaignsController extends Controller
{
    public function index()
    {
    	$campaigns = Campaigns::all();
    	// echo "<pre>";print_r($campaigns);die;
        return view('campaigns.campaigns');
    }
}
