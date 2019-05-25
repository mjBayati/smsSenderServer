<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/entities.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$phonesData = new PhonesData($db);
 
// set ID property of record to read
$phonesData->number = isset($_GET['number']) ? $_GET['number'] : die();
 
// read the details of product to be edited
$phonesData->readOne(number);
 
if($phonesData->number!=null){
    // create array
    $phonesData_arr = array(
        "id" =>  $phonesData->id,
        "number" => $phonesData->number,
        "condition" => $phonesData->condition,
        "createdAt" => $phonesData->createdAt,
        "updatedAt" => $phonesData->updatedAt,
        "loctionId" => $phonesData->locationId
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($phonesData_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user product does not exist
    echo json_encode(array("message" => "phone number data does not exist."));
}
?>