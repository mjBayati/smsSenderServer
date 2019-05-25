<?php

require "redisService.php";
require "CurlService.php";
require "../phonesApis/create.php";

class MainApiController{
    private $redisDb;
    private static $lastFlag = false;

    public static function addItem($item){
        $client = new Predis\Client();

        self::$lastFlag = $client->get('isCounterSeted');

        if(self::$lastFlag == true){
            $finalDataObject = RedisServices::addNewItem($item);


        }
        else{
            RedisServices::intiRedis();
            $finalDataObject = RedisServices::addNewItem($item);
        }

        //add record to database
        creatNewRecord($finalDataObject);
    }
    public static function handleSendingMails(){
        // sleep(5);

        $redisData = null;
        $client = new Predis\Client();
        $result = null;    

        $redisData = RedisServices::getNewItemFromQueue($client);
        echo json_encode($redisData);

        // while(true){
        //     $redisData = RedisServices::getNewItemFromQueue($client);
            
        //     if ($redisData == null)
        //         break;
            
        //     echo json_encode($redisData);
        //     // sending sms's 
        //     $result;
        //      try{
        //         $result = CurlService::send('localhost:81', $redisData);
        //         if($result == 400){
        //             throw new Exception('error on receiver');
        //         }
        //     }catch(Exception $e){
        //         $result = CurlService::send('localhost:82', $redisData);                   
        //         if($result == 400){
        //             self::addItem($redisData);
        //         }
        //     }
        // }
    }   
}