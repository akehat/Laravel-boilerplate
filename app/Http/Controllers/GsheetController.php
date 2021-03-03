<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaigns;
use Google_Client;
use DB;
use Google_Service_Sheets;
use Google_Service_Drive;
use Google_Service_Sheets_Spreadsheet;
use Google_Service_Sheets_ValueRange;
use Google_Service_Sheets_ClearValuesRequest;
use Google_Service_Drive_Permission;

class GsheetController extends Controller
{
    public function getClient() {
    	$credentials = getenv( 'GOOGLE_APPLICATION_CREDENTIALS' );
    	// echo "<pre>";print_r($credentials);die('fgf');

	    $client = new Google_Client();
        putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/credentials.json');
	    // $client->setAuthConfig( getenv( 'GOOGLE_APPLICATION_CREDENTIALS' ) );
	    $client->useApplicationDefaultCredentials();
	    $client->setApplicationName('theName');
	    $client->setAccessType('offline');
	    $client->setScopes(
        ['https://www.googleapis.com/auth/spreadsheets',
        'https://www.googleapis.com/auth/drive']);


        return $client;

    }
    
    public function addNewGsheet($data,$columns){


    	$client = $this->getClient();
		$service = new Google_Service_Sheets($client);
		$drive = new Google_Service_Drive($client);
        $ss = $service->spreadsheets->create(new Google_Service_Sheets_Spreadsheet([
		    'properties' => [
		        'title' =>  $data['cause_slug']
		    ]
	
        ]));
		$newPermission = new Google_Service_Drive_Permission();
	   // $newPermission->setEmailAddress("geetanjali.secureweb@gmail.com");
	   $newPermission->setEmailAddress("chesedfundapi@gmail.com");
		$newPermission->setType('user');
		$newPermission->setRole('writer');
		$optParams = array('sendNotificationEmail' => false);
		$drive->permissions->create($ss->spreadsheetId,$newPermission,$optParams);


		$savedata = array(
          'google_sheet_id' => $ss->spreadsheetId,
          'google_sheet_url' => $ss->spreadsheetUrl,             
        );

 		$get_range = 'A1:Z1';
 		$params = [ 'valueInputOption' => 'RAW'];
	    $update_Campaign =  DB::table('campaigns')->where('cause_id',$data['cause_id'])->update($savedata);
	    $values   = [];
 		$values = [
            ["ID","Sub Domain", "Cause name","Cause Slug", "Cause Id", "Donation Id","Donor First Name", "Donar Last Name", "Donor Email","Donor Phone", "Donor Street", "Donor City","Donor State", "Donor Zip", "Status","Captured", "Amount", "Currency","Source", "Additional Info", "Converted Amount", "Converted Currency", "Fee","Fee Currency", "Net", "Net Currency"]                     
        ];

	  
		$body   = new Google_Service_Sheets_ValueRange(['values' => $values]);        
        $result = $service->spreadsheets_values->update($ss->spreadsheetId, $get_range, $body, $params);
        $this->updateGSheet($ss->spreadsheetId,$data['cause_id'],$columns);
    }
    public function updateGSheet($spreadsheetId,$cause_id,$columns){
    
  	    $client = $this->getClient();
		$service = new Google_Service_Sheets($client);
		$drive = new Google_Service_Drive($client);
		$getDonation = DB::table('donations')->select('*')->where('donations.cause_id',$cause_id)->get();
   
       // echo "<pre>";print_r($getDonation);die('tts');

	   //  if (!empty($columns)) {
	   //         foreach ( $columns as $value ) {

	   //             $value = [
	   //                 $value
	   //             ];
	  
	   //             array_push( $values, $value );
	   //         }
	  	// } 
	
		if(isset($getDonation) && !empty($getDonation)){
			$i=2;
	        foreach ($getDonation as $key => $donation) {
	            if($donation->cause_id = $cause_id){
	                $valueRange= new Google_Service_Sheets_ValueRange();
	                $valueRange->setValues(["values" => ["{$donation->id}", "{$donation->subdomain}","{$donation->cause_name}","{$donation->cause_slug}","{$donation->cause_id}","{$donation->donation_id}","{$donation->donor_first_name}","{$donation->donor_last_name}","{$donation->donor_email}","{$donation->donor_phone}","{$donation->donor_street}","{$donation->donor_city}","{$donation->donor_state}","{$donation->donor_zip}","{$donation->status}","{$donation->captured}","{$donation->amount}","{$donation->currency}","{$donation->source}","{$donation->additional_info}","{$donation->converted_amount}","{$donation->converted_currency}","{$donation->fee}","{$donation->fee_currency}","{$donation->net}","{$donation->net_currency}"]]); // Add two values
	                    $conf = ["valueInputOption" => "RAW"];
	                    $service->spreadsheets_values->update($spreadsheetId,'A'.$i.':Z'.$i , $valueRange, $conf);
	                    // $service->spreadsheets_values->update($spreadsheetId,'A1:Z1' , $valueRange, $conf);
	            }
	            $i++;
	        }
	    }
 
	    
 		

	}
	
}
