<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/dbclass.php';

include_once '../entities/phoneNumber.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$PhonesData = new PhonesData($connection);

$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->number) &&
    !empty($data->condition) &&
    !empty($data->locationId)
){
    $PhonesData->number = $data->number;
    $PhonesData->condition = 0; //0 is initialization and start of sending sms
    $PhonesData->createdAt = date('Y-m-d H:i:s');
    $PhonesData->updatedAt = date('Y-m-d H:i:s');
    $PhonesData->locatationId = $data->port;

    if($PhonesData->create()){
        http_response_code(201);
        echo '{';
            echo '"message": "phone record was created."';
        echo '}';
    }
    else{
        http_response_code(503);
        echo '{';
            echo '"message": "Unable to create phoneRecord."';
        echo '}';
    }
}else {
    http_response_code(400);

    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}
?>