<?php
// header("Content-Type: application/json; charset=UTF-8");

include_once '../config/dbClass.php';
include_once '../entities/phoneNumber.php';


function readTenMostUsedNumber(){
    $dbclass = new DBClass();
    $connection = $dbclass->getConnection();
    $phoneReadData = new PhonesData($connection);

    $stmt = $phoneReadData->read();
    // $count = $stmt->rowCount();


    if ($stmt->num_rows > 0) {
        $phonesReqs = array();
        $phonesReqs["body"] = array();
        $phonesReqs["count"] = $stmt->num_rows;
        while($row = $stmt->fetch_assoc()) {
            extract($row);
            $p  = array(
                "number" => $number,
                "c" => $c,
            );
            array_push($phonesReqs["body"], $p);
        }
        return $phonesReqs;
    } else {
        echo "0 results";
    } 

}
?>