<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // include database and object files
    include_once '../config/dbClass.php';
    include_once '../entities/phoneNumber.php';
   
function updateRecord($data, $status, $receiverPort){
    // get database connection
    $database = new DBClass();
    $db = $database->getConnection();
    
    // prepare product object
    $phonesData = new PhonesData($db);
    
    
    $data = json_decode($data, true);

    // set product property values
    $phonesData->id = $data["id"];
    $phonesData->status = '"' . $status . '"';
    $phonesData->serviceHostPort = $receiverPort;
    $phonesData->updatedAt = '"' . date('Y-m-d H:i:s') .'"';
    
    // update the product
    if($phonesData->update()){
    
        // set response code - 200 ok
        http_response_code(200);
    
        // tell the user
        // echo json_encode(array("message" => "sms status is updated."));
    }
    
    // if unable to update the product, tell the user
    else{
    
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the user
        echo json_encode(array("message" => "Unable to update sms condition."));
    }
}
?>