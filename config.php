<?php 

//if session is not started then start session
if(!isset($_SESSION)){
    session_start();
}

//include verndor
require_once __DIR__ . '/vendor/autoload.php';
use Kreait\Firebase\Factory;

//AppDetails

$app=[
    'app_name'=>'Iota Server',
    'version'=>'1.0.0',
    'developed_by'=>'Roborosx',
    'app_url'=>'http://localhost/IotaServer',
    'usage_type'=>[
        "TESTING",
        "DEPLOYMENT",
        "STUDENT",
        "PROFESSIONAL"
    ]
];




//database Details

$serverName="localhost";
$userName="root";
$password="";
$database="iot_server";

try{
    $conn = new mysqli($serverName, $userName, $password, $database);
    $firebaseFile= __DIR__ . '/firebase.json';

$factory = (new Factory)
    ->withServiceAccount($firebaseFile)
    ->withDatabaseUri('https://dumtest-a242e-default-rtdb.asia-southeast1.firebasedatabase.app/RosXIOTA');

$auth = $factory->createAuth();
// print_r($auth);
$rtdb = $factory->createDatabase();
// $cloudMessaging = $factory->createMessaging();
// $remoteConfig = $factory->createRemoteConfig();
// $cloudStorage = $factory->createStorage();
// $firestore = $factory->createFirestore();
}Catch(Exception $e){
    die("Database Connection Failed: ".$e->getMessage());
}




include __DIR__ . '/Functions.php';