<?php
    $randNumber = rand();
    if($randNumber % 2 == 0){
        http_response_code(400);
        echo "string";
    }else{
        http_response_code(200);
        echo "string1";
    }
?>