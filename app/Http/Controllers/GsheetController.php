<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaigns;
use App\Models\Donations;
use Google_Client;
use DB;
use Google_Service_Sheets;
use Google_Service_Drive;
use Google_Service_Sheets_Spreadsheet;
use Google_Service_Sheets_ValueRange;
use Google_Service_Sheets_ClearValuesRequest;
use Google_Service_Drive_Permission;
use Log;

class GsheetController extends Controller
{
    public function getClient() {
    	$credentials = getenv( 'GOOGLE_APPLICATION_CREDENTIALS' );
    	

	$client = new Google_Client();

	// print_r(__DIR__);exit;
        putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/credentials.json');
        $credentials = getenv( 'GOOGLE_APPLICATION_CREDENTIALS' );

       	// print_r(file_get_contents($credentials));exit;


        // echo "<pre>";print_r($credentials);die('fgf');
	// $client->setAuthConfig( getenv( 'GOOGLE_APPLICATION_CREDENTIALS' ) );
	    $client->useApplicationDefaultCredentials();
	    $client->setApplicationName('theName');
	    //$client->setApplicationName('tcfapi');
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
	   	//$newPermission->setEmailAddress("geetanjali.secureweb@gmail.com");
		$newPermission->setEmailAddress("chesedfundapi@gmail.com");
		// $newPermission->setEmailAddress("tcfapi2@tcfapi.iam.gserviceaccount.com");
		// $newPermission->setEmailAddress("secure@tcfapi.iam.gserviceaccount.com");
		// $newPermission->setEmailAddress("swt.test2018@gmail.com");
		$newPermission->setType('user');
		// $newPermission->setRole('owner');
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
            ["ID", "Cause name","Cause Slug",  "Donation Id","Donor First Name", "Donar Last Name", "Donor Email","Donor Phone", "Donor Street", "Donor City","Donor State", "Donor Zip", "Status","Captured", "Amount", "Currency","Source", "Additional Info", "Converted Amount", "Converted Currency", "Fee","Fee Currency", "Net", "Net Currency","Affiliate","Created at"]                     
        ];

	  
		$body   = new Google_Service_Sheets_ValueRange(['values' => $values]);        
        $result = $service->spreadsheets_values->update($ss->spreadsheetId, $get_range, $body, $params);
        $this->updateGSheet($ss->spreadsheetId,$data['cause_id'],$columns);
    }
    public function updateGSheet($spreadsheetId,$cause_id,$columns){
    
    	// print_r($spreadsheetId);exit;

  	    $client = $this->getClient();
		$service = new Google_Service_Sheets($client);


		$drive = new Google_Service_Drive($client);


		$getDonation = DB::table('donations')->select('*')->where('donations.cause_id',$cause_id)->where('sheet_updated',0)->get();

		$LastDonation = DB::table('donations')->select('*')->where('donations.cause_id',$cause_id)->where('sheet_updated',1)->latest()->first();
   		Log::channel('customlog')->info("LastDonation :".json_encode($LastDonation));
      	// echo "<pre>";print_r($LastDonation);die('tts');

	   //  if (!empty($columns)) {
	   //         foreach ( $columns as $value ) {

	   //             $value = [
	   //                 $value
	   //             ];
	  
	   //             array_push( $values, $value );
	   //         }
	  	// } 
	
		if(isset($getDonation) && !empty($getDonation)){

			$i = 1;
			if($LastDonation){
				if($LastDonation->sheet_row){
					$i=$LastDonation->sheet_row;
				}
			}
			
	        foreach ($getDonation as $key => $donation) {
	            if($donation->cause_id == $cause_id){

	            	$donationObj = Donations::where('donation_id',$donation->donation_id)->where('cause_id',$cause_id)->first();
	            	Log::channel('customlog')->info("donationObj :".json_encode($donationObj));
	            	// print_r($donationObj->id);
	            	// DB::table('donations')
		            //     ->where('cause_id', $cause_id)
		            //     ->update(['sheet_updated' => 1,'sheet_row' => $i]);


	            	if(!$donationObj->sheet_row){
	            		$i = $rowNo = $i+1;
	            		$donationObj->sheet_row = $i;
	            		$donationObj->sheet_updated = 1;
	            		// $rowNo = $i;
	            	}else{
	            		$donationObj->sheet_updated = 1;

	            		$rowNo = $donationObj->sheet_row;
	            	}

	            	Log::channel('customlog')->info("rowNo :".$rowNo);
	            	Log::channel('customlog')->info(" ++++++++++++++++++++++++++++ ");



	            	// print_r($i);

	            	$donationObj->save();



	                $valueRange= new Google_Service_Sheets_ValueRange();
	                $valueRange->setValues(["values" => ["{$donation->id}","{$donation->cause_name}","{$donation->cause_slug}","{$donation->donation_id}","{$donation->donor_first_name}","{$donation->donor_last_name}","{$donation->donor_email}","{$donation->donor_phone}","{$donation->donor_street}","{$donation->donor_city}","{$donation->donor_state}","{$donation->donor_zip}","{$donation->status}","{$donation->captured}","{$donation->amount}","{$donation->currency}","{$donation->source}","{$donation->additional_info}","{$donation->converted_amount}","{$donation->converted_currency}","{$donation->fee}","{$donation->fee_currency}","{$donation->net}","{$donation->net_currency}","{$donation->affiliate}","{$donation->created_at}"]]); // Add two values
	                    $conf = ["valueInputOption" => "RAW"];
	                    $service->spreadsheets_values->update($spreadsheetId,'A'.$rowNo.':Z'.$rowNo , $valueRange, $conf);
	                    // $service->spreadsheets_values->update($spreadsheetId,'A1:Z1' , $valueRange, $conf);
	            }
	            $i++;
	        }
	    }
 
	    
 		

	}
	
}
