<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\Models\Campaigns;

class ApiCampaignsController extends Controller
{
    public function index()
    {
    	die('test');
    	$campaigns = Campaigns::all();
    	// echo "<pre>";print_r($campaigns);die;
        return view('campaigns');
    }
}
