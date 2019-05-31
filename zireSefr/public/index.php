<?php

// require "../services/CurlService.php";
include_once "../services/MainController.php";
include_once "../services/redisService.php";
require_once "../vendor/autoload.php";


$request_uri = explode('?', $_SERVER['REQUEST_URI']);

$data = [
    "body" => $_GET['body'],
    "number" => $_GET['number']
];

// Route it up!
switch ($request_uri[0]) {
    case '/sms/send/':
        // $redis = new Redis(); 
        // $redis->connect('127.0.0.1', 6379);    
        MainApiController::addItem(json_encode($data));
        break;
    case '/':
        break;
    default:
        header('HTTP/1.0 404 Not Found');
        break;
}
    
function LaunchBackgroundProcess($command){
    // Run command Asynchroniously (in a separate thread)
    // Linux/UNIX
    $command = $command .' /dev/null &';
    $handle = popen($command, 'r');
    if($handle!==false){
      pclose($handle);
      return true;
    } else {
      return false;
    }
}

$numberOfAllSendedSms = RedisServices::getNumberOfSendedSms(81, 82);
$numberOfSmsSendedByPort81 = RedisServices::getNumberOfSendedSmsByThisPort(81);
$numberOfSmsSendedByPort82 = RedisServices::getNumberOfSendedSmsByThisPort(82);
$numberOfFaultByPort81 = RedisServices::getNumberOfFaultByThisPort(81);
$numberOfFaultByPort82 = RedisServices::getNumberOfFaultByThisPort(82);
$mostUsedNumbers = MainApiController::readTenMostRepeated();


MainApiController::readTenMostRepeated();
LaunchBackgroundProcess("php bgRunner.php");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
    <link rel="stylesheet" href="http://localhost:83/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://localhost:83/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <meta charset="utf-8">
    <title></title>
  </head>
  <body class="jumbotron w-100" id="root">
    <section class="row" id="headerWrapper">
        <header class="col-12 d-flex flex-row justify-content-center align-items-center" id="headerPart">
            <h6>sms status reporter</h6>
        </header>
    </section>
    <section class="container d-flex flex-row align-items-center justify-content-center" id="mainContentWrapper">
        <div class="col-md-8 col-12 d-flex flex-column align-items-center justify-content-center">
            <div class="row w-100 d-flex flex-row justify-content-between align-items-center" id="allSendedSmsPart">
                <h6>number of all sended sms's: </h6>
                <h6>
                    <?php echo $numberOfAllSendedSms; ?>
                </h6>
            </div>
            <div class="row w-100 d-flex flex-row justify-content-center align-items-center" id="hostTablePart">
                    <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">host port</th>
                        <th scope="col">usage</th>
                        <th scope="col">fault telorance</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>81</td>
                        <td>
                            <?php echo $numberOfSmsSendedByPort81/$numberOfAllSendedSms; ?>
                        </td>
                        <td>
                            <?php echo $numberOfFaultByPort81/$numberOfSmsSendedByPort81; ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>82</td>
                        <td>
                            <?php echo $numberOfSmsSendedByPort82/$numberOfAllSendedSms; ?>
                        </td>
                        <td>
                            <?php echo $numberOfFaultByPort82/$numberOfSmsSendedByPort82; ?>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
            <div class="row w-100 d-flex flex-column justify-content-center align-items-center" id="mostSendedSmsNumbersPart">
                <h6 id="mostSendedHeaderPart">the 10 number with most range of sending sms to them</h6>
                <div class="w-100 row d-flex flex-row justify-content-between align-items-center" id="numberSection">
                    <h6>phone number</h6>
                    <h6>number of sms's</h6>
                </div>
                <?php for($num = 0; $num < $mostUsedNumbers["count"]; $num++){
                    echo "<div class='w-100 row d-flex flex-row justify-content-between align-items-center' id='numberSection'>";
                    echo "<h6>" . $mostUsedNumbers["body"][$num]["number"] . "</h6>";
                    echo "<h6>" . $mostUsedNumbers["body"][$num]["c"] . "</h6>";
                    echo "</div>";
                }?>
            </div>
        </div>
    </section>
  <script type="text/javascript" src="http://localhost:83/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="http://localhost:83/js/jqueryfile.js"></script>
  <script type="text/javascript" src="http://localhost:83/js/eventsHandeler.js"></script>
  </body>
</html>



