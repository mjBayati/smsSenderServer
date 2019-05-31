<?php

require_once "../vendor/autoload.php";

use Predis\Client;
$redis = null;

class RedisServices{
    private static $listName = "smsList";
    private static $client;
    private static $counter = "counter";
    public static function intiRedis(){
        try{
            // self::$client = new Predis\Client([
            //     'scheme' => 'tcp',
            //     'host'   => 'localhost',
            //     'port'   => 55000,
            //     "persistent" => "1",
            // ]);
            self::$client = new Predis\Client();
            self::$client->set('counter', 1);   
            self::$client->set('isCounterSeted', true);
            echo "client connected:\n";
        }catch(Predis\Connection\ConnectionException $exception){
            echo "error on adding connection";
        }
        
    }

    public static function addNewItem($newItem){
        try{
            self::$client = new Predis\Client();
            // echo $newItem;

            $tempResult = json_decode($newItem, true);


            $value = self::$client->get('counter');
            self::$client->incr('counter');


            $tempResult = array_merge($tempResult,["id" => $value]);
            

            self::$client->rpush(self::$listName, json_encode($tempResult));
            return $tempResult;            
        }catch(Predis\Connection\ConnectionException $exception){
            echo $exception->getMessage();
        }
    }

    public static function addExitingItemToQueueAgin($Item){
        self::$client = new Predis\Client();
        $tempResult = json_decode($Item, true);
        self::$client->rpush(self::$listName, json_encode($tempResult));
        return $tempResult;
    }   

    public static function getNewItemFromQueue($conn){
        $resultData = null;
        try{
            $resultData = $conn->lpop(self::$listName);

            // return array(,$resultData);
            return $resultData;            
        }catch(Predis\Connection\ConnectionException $exception){
            echo $exception->getMessage();
            return null;
        }
    }
    

    public static function getNumberOfSendedSms($hostPortNumberOne, $hostPortNumberTwo){
        return self::getNumberOfSendedSmsByThisPort($hostPortNumberOne) +
            self::getNumberOfSendedSmsByThisPort($hostPortNumberTwo);
    }

    public static function incNumberOfSendedSmsByThisPort($hostPortNumber){
        $checker = "is" . $hostPortNumber . "seted";
        $client = new Predis\Client();
        if(!$client->get($checker)){
            $client->set($checker, true);
            $client->set($hostPortNumber, 1);
        }
        else{
            $client->incr($hostPortNumber);
        }
    }

    public static function incNumberOfFaultByThisPort($hostPortNumber){
        $checker = "is" . $hostPortNumber . "Faultseted";
        $redisId = $hostPortNumber . "FaultNumber";
        $client = new Predis\Client();
        if(!$client->get($checker)){
            $client->set($checker, true);
            $client->set($redisId, 1);
        }
        else{
            $client->incr($redisId);
        }
    }

    public static function getNumberOfSendedSmsByThisPort($hostPortNumber){
        $client = new Predis\Client();
        return $client->get($hostPortNumber);
    }

    public static function getNumberOfFaultByThisPort($hostPortNumber){
        $redisId = $hostPortNumber . "FaultNumber";
        $client = new Predis\Client();
        return $client->get($redisId);
    }
}

?>