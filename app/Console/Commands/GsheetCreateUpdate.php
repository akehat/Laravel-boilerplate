<?php
namespace App\Console\Commands;

use Illuminate\Http\Request;
use App\Models\Campaigns;
use App\Models\Donations;
use Illuminate\Console\Command;
use Google_Client;
use DB;
use Google_Service_Sheets;
use Google_Service_Drive;
use Google_Service_Sheets_Spreadsheet;
use Google_Service_Sheets_ValueRange;
use Google_Service_Sheets_ClearValuesRequest;
use Google_Service_Drive_Permission;
use Log;

class GsheetCreateUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Gsheet:update';

	
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
	 
	 
    public function handle()
    {
        $client = new Google_Client();
        putenv('GOOGLE_APPLICATION_CREDENTIALS='.app_path().'/Http/Controllers/credentials.json');
        $credentials = getenv( 'GOOGLE_APPLICATION_CREDENTIALS' );
        $client->useApplicationDefaultCredentials();
        $client->setApplicationName('theName');
        $client->setAccessType('offline');
        $client->setScopes(
            ['https://www.googleapis.com/auth/spreadsheets',
            'https://www.googleapis.com/auth/drive']);
        
        $service = new Google_Service_Sheets($client);
        $drive = new Google_Service_Drive($client);
        $getDonation = DB::table('donations')->select('*')->where('sheet_updated',0)->get();
        if(isset($getDonation) && !empty($getDonation)){
            foreach ($getDonation as $key => $donation) {
                $LastDonation = DB::table('donations')->select('*')->where('donations.cause_id',$donation->cause_id)->where('sheet_updated',1)->latest()->first();
                Log::channel('customlog')->info("LastDonation :".json_encode($LastDonation));

                $donationObj = Donations::where('donation_id',$donation->donation_id)->first();
                Log::channel('customlog')->info("donationObj :".json_encode($donationObj));
                $i = 1;
                if($LastDonation){
                    if($LastDonation->sheet_row){
                        $i=$LastDonation->sheet_row;
                    }
                }
                if(!$donationObj->sheet_row){
                    $i = $rowNo = $i+1;
                    $donationObj->sheet_row = $i;
                    $donationObj->sheet_updated = 1;
                }else{
                    $donationObj->sheet_updated = 1;
                    $rowNo = $donationObj->sheet_row;
                }

                Log::channel('customlog')->info("rowNo :".$rowNo);
                Log::channel('customlog')->info(" ++++++++++++++++++++++++++++ ");

                $donationObj->save();
                $getCampaigns = Campaigns::where('cause_id', '=', $donation->cause_id)->first();
                $spreadsheetId = $getCampaigns->google_sheet_id;

                $valueRange= new Google_Service_Sheets_ValueRange();
                $valueRange->setValues(["values" => ["{$donation->id}","{$donation->cause_name}","{$donation->cause_slug}","{$donation->donation_id}","{$donation->donor_first_name}","{$donation->donor_last_name}","{$donation->donor_email}","{$donation->donor_phone}","{$donation->donor_street}","{$donation->donor_city}","{$donation->additional_info}","{$donation->team}","{$donation->status}","{$donation->captured}","{$donation->amount}","{$donation->currency}","{$donation->source}","{$donation->additional_info}","{$donation->converted_amount}","{$donation->converted_currency}","{$donation->fee}","{$donation->fee_currency}","{$donation->net}","{$donation->net_currency}","{$donation->affiliate}","{$donation->created_at}"]]); 
                    $conf = ["valueInputOption" => "RAW"];
                    $service->spreadsheets_values->update($spreadsheetId,'A'.$rowNo.':Z'.$rowNo , $valueRange, $conf);
                    // $service->spreadsheets_values->update($spreadsheetId,'A1:Z1' , $valueRange, $conf);
            
                $i++;
            }       
        }
    }
}


