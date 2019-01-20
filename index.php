<?php

require "vendor/autoload.php";

use Yas\Controllers\CountryController;
use Yas\Repository\CountryRepository;
use ApiHandler\ApiService;

$dotenv = Dotenv\Dotenv::create(__DIR__ . '/config');
$dotenv->load();
$service = new ApiService();
$repo = new CountryRepository($service);
$ctrl = new CountryController($repo);
if($argc > 1) {
	echo $ctrl->getCountryDetails($argv);
} else {
    echo "Please provide the country name";
    exit();
}
// use FindDate\ManageCSV;
// use FindDate\ExportDates;

// const MONTHS = 12;

// if($argc > 1) {
//     $filename = $argv[1];
//     if(!preg_match('/^([-\.\w]+)$/', $filename)) {
//         echo 'Provided filename has illegal characters.' . "\n";
//         exit();
//     }
// } else {
//     echo "Please provide the csv file name";
//     exit();
// }
// try{
//     $manageCSV = new ManageCSV($filename, 'w'); 
//     $paymentDate = new ExportDates($manageCSV);
//     if($paymentDate->exportPaymentDates(MONTHS)) {
//         echo "$filename.csv file has been created successfully at " . getcwd() ."\n";
//     } else {
//         echo "Error while downloading $filename.csv " . "\n";
//     }
// } catch(Exception $e) {
//     echo "Error while creating $filename.csv : " . $e->getMessage() . "\n";
// }