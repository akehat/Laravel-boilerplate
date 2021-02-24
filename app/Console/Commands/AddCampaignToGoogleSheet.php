<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Google_Client;

class AddCampaignToGoogleSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AddCampaign:GoogleSheet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add or update campaign to google sheet';

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
        $client->setApplicationName('APPLICATION_NAME');
        $client->setScopes('https://www.googleapis.com/auth/spreadsheets');
        $client->setAuthConfig(__DIR__ . '/credential.json');
        $client->setAccessToken('2e674c898fd8acc635288f20e957e9dab6d75938');

        $service = new Google_Service_Sheets($client);
        $sheetID = '18J2CJGZmU35AeDXIIAL2z0nngUCRRNg98WczD-lMpYk';
        $range = 'Sheet1!A2:z';
        $sheetInfo = $service->spreadsheets_values->get($sheetID, $range);
    }
}
