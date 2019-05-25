<?php

require "redisService.php";
require "CurlService.php";

class MainApiController{
    private $redisDb;
    private static $lastFlag = false;

    public static function addItem($item){
        $client = new Predis\Client();

        self::$lastFlag = $client->get('isCounterSeted');

        if(self::$lastFlag == true){
            $incResult = RedisServices::addNewItem($item);
            echo $incResult;
        }
        else{
            RedisServices::intiRedis();
            RedisServices::addNewItem($item);
            self::$lastFlag = true;
        }
    }
    public static function handleSendingMails(){
        $redisData = null;
        $client = new Predis\Client();
        while(true){
            $redisData = RedisServices::getNewItemFromQueue($client);
            
            if ($redisData == null)
                break;
            
            echo json_encode($redisData);
            // sending sms's 
            $result;
            try{
                $result = CurlService::send('localhost:81', $redisData);
                if($result == 400){
                    throw new Exeption();
                }
            }catch(Exeption $e){
                $result = CurlService::send('localhost:82', $redisData);                   
                if($result == 400){
                    self::addItem($redisData);
                }
            }
        }
        echo "queue is empty:\n";
        echo $client->llen("smsList");
    }   
}