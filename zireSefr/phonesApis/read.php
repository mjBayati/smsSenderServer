<?php
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/dbclass.php';
include_once '../entities/phoneNumber.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$phoneReadData = new PhonesData($connection);

$stmt = $phoneReadData->read();
$count = $stmt->rowCount();

if($count > 0){


    $phonesReqs = array();
    $phonesReqs["body"] = array();
    $phonesReqs["count"] = $count;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $p  = array(
              "id" => $id,
              "number" => $number,
              "condition" => $condition,
              "createdAt" => $createdAt,
              "updatedAt" => $updatedAt,
              "location_id" => $location_id
        );

        array_push($phonesReqs["body"], $p);
    }

    http_response_code(200);

    echo json_encode($phonesReqs);
}

else {
    http_response_code(404);

    // echo json_encode(
    //     array("body" => array(), "count" => 0);
    // );
}
?>