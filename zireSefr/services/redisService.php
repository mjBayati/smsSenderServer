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
            // self::$client->set('counter', 1);
            self::$client->set('isCounterSeted', true);
            echo "client connected:\n";
        }catch(Predis\Connection\ConnectionException $exception){
            echo "error on adding connection";
        }
        
    }

    public static function addNewItem($newItem){
        try{
            self::$client = new Predis\Client();
            // $value = self::$client->get('counter');
            self::$client->rpush(self::$listName, $newItem);
            // self::$client->incr('counter');
            return self::$client->llen(self::$listName);            
        }catch(Predis\Connection\ConnectionException $exception){
            echo $exception->getMessage();
        }
    }

    public static function getNewItemFromQueue($conn){
        $resultData = null;
        try{
            $resultData = $conn->blpop(self::$listName, 20);
            return $resultData;            
        }catch(Predis\Connection\ConnectionException $exception){
            echo $exception->getMessage();
            return null;
        }
    }
}

?>