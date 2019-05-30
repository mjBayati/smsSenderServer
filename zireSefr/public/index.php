<?php

// require "../services/CurlService.php";
include_once "../services/MainController.php";
require_once "../vendor/autoload.php";


$request_uri = explode('?', $_SERVER['REQUEST_URI']);

$data = [
    "body" => $_GET['body'],
    "number" => $_GET['number']
];

// Route it up!
switch ($request_uri[0]) {
    case '/sms/send/':
        // $redis = new Redis(); 
        // $redis->connect('127.0.0.1', 6379);    
        MainApiController::addItem(json_encode($data));
        break;
    case '/':
        break;
    default:
        header('HTTP/1.0 404 Not Found');
        break;
}
    
function LaunchBackgroundProcess($command){
    // Run command Asynchroniously (in a separate thread)
    // Linux/UNIX
    $command = $command .' /dev/null &';
    $handle = popen($command, 'r');
    if($handle!==false){
      pclose($handle);
      return true;
    } else {
      return false;
    }
}


LaunchBackgroundProcess("php bgRunner.php");

require('home.html');


?>

