<?php

require "redisService.php";
require "CurlService.php";
require_once "../phonesApis/create.php";
require_once "../phonesApis/update.php";

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
 
        // $redisData = RedisServices::getNewItemFromQueue($client);
        // echo json_encode($redisData);

        while(true){
            sleep(1);
            $redisData = RedisServices::getNewItemFromQueue($client);
            
            if ($redisData == null)
                break;
                        

            $result;
             try{
                $result = CurlService::send('localhost:81', $redisData);
                updateRecord($redisData, "message sending", 81);
                RedisServices::incNumberOfSendedSmsByThisPort(81);
            
                if($result == 400){
                    RedisServices::incNumberOfFaultByThisPort(81);
                    throw new Exception('error on receiver');
                }
                updateRecord($redisData, "message sent", 81);
            }catch(Exception $e){
                $result = CurlService::send('localhost:82', $redisData);
                updateRecord($redisData, "message resent", 82);                   
                RedisServices::incNumberOfSendedSmsByThisPort(82);

                if($result == 400){
                    RedisServices::addExitingItemToQueueAgin($redisData);
                    updateRecord($redisData, "message pending", 82);
                    RedisServices::incNumberOfFaultByThisPort(82);
                }else{
                    updateRecord($redisData, "message sent", 82);
                }
            }
        }

        echo "the Queue size: ";
        echo $client->llen('smsList');
    }   
}