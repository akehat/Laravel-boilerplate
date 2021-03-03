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
        return view('donations.donations');
    }
    public function show($id)
    {
      
      return view('donations.show', compact('id')); 
     
    }
}
