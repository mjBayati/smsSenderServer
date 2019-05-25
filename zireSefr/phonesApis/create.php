<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/dbClass.php';
include_once '../entities/phoneNumber.php';
include_once '../config/install.php';

function creatNewRecord($data){
    $dbclass = new DBClass();
    echo "here";
    $connection = $dbclass->getConnection();
    $PhonesData = new PhonesData($connection);

   

    if(
    !empty($data["number"])
    ){
        
        $PhonesData->id = $data["id"];
        $PhonesData->number = $data["number"];
        $PhonesData->status = "record created";
        $PhonesData->bodyText = $data["body"]; //0 is initialization and start of sending sms
        $PhonesData->createdAt = date('Y-m-d H:i:s');
        $PhonesData->updatedAt = date('Y-m-d H:i:s');
        $PhonesData->serviceHostPort = 0; // yet not sended

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
}



// $data = json_decode(file_get_contents("php://input"));


// ?>