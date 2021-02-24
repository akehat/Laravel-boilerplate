<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaigns;

use App\Models\Donations;

class DonationsController extends Controller
{
    public function index()
    {
    	$donations = Donations::all();
    	// echo "<pre>";print_r($campaigns);die;
        return view('donations.donations');
    }
}
