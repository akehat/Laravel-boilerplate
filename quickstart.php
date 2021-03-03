<?php
require __DIR__ . '/vendor/autoload.php';

if (php_sapi_name() != 'cli') {
    // throw new Exception('This application must be run on the command line.');
}

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient() {
    $client = new Google_Client();
    $client->setAuthConfig('credentials.json');
    $client->setApplicationName('theName');
    $client->setAccessType('offline');
    // $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
    $client->setScopes(
        ['https://www.googleapis.com/auth/spreadsheets',
        'https://www.googleapis.com/auth/drive']);


    return $client;
}


// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Sheets($client);
$drive = new Google_Service_Drive($client);

$ss = $service->spreadsheets->create(new Google_Service_Sheets_Spreadsheet([
    'properties' => [
        'title' => 'Testing'
    ]]));
$newPermission = new Google_Service_Drive_Permission();
$newPermission->setEmailAddress("geetanjali.secureweb@gmail.com");
$newPermission->setType('user');
$newPermission->setRole('writer');
$optParams = array('sendNotificationEmail' => false);
$drive->permissions->create($ss->spreadsheetId,$newPermission,$optParams);



// $spreadsheet = new Google_Service_Sheets_Spreadsheet([
//     'properties' => [
//         'title' => 'Testing'
//     ]
// ]);
// $spreadsheet = $service->spreadsheets->create($spreadsheet, [
//     'fields' => 'spreadsheetId',''
// ]);
// printf("Spreadsheet ID: %s\n", $ss->spreadsheetId);







// Prints the names and majors of students in a sample spreadsheet:
// https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
// $spreadsheetId = '1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms';
// $range = 'Class Data!A2:E';
// $response = $service->spreadsheets_values->get($spreadsheetId, $range);
// $values = $response->getValues();

// if (empty($values)) {
//     print "No data found.\n";
// } else {
//     print "Name, Major:\n";
//     foreach ($values as $row) {
//         // Print columns A and E, which correspond to indices 0 and 4.
//         printf("%s, %s\n", $row[0], $row[4]);
//     }
// }