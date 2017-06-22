<?php

$response = file_get_contents("php://input");
$update = json_decode($response, true);

function processMessage()
{

$response = file_get_contents("php://input");
$update = json_decode($response, true);

 $actionName=$update["result"]["action"];
    $city = $update["result"]["parameters"]["geo-city"];
    switch($actionName)
    {
        case 'weather' :   $speech = "Weather in ".$city." : Clear sky, 29 deg c ";
                        $displayText = "Weather in ".$city." : Clear sky, 29 deg c ";
                        $source = "weather";
                        break;
        case 'sslcResult' :   $speech = "Congrats, You are eligible for higher studies. ";
                        $displayText = "Congrats, You are eligible for higher studies.";
                        $source = "sslcResult";
                        break;

            default :   $speech = $city." Something went wrong ! Try again...";
                        $displayText = $actionName."Something went wrong ! Try again...";
                        $source = "DGO-Server";
                        break;
    }
    
    sendMessage(array("source"=>$source,"speech"=>$speech,"displayText"=>$displayText,"contextOut"=> array()));
                        
    
      
    
}

function sendMessage($parameters)
{
    header('Content-type: application/json');
    echo json_encode($parameters);
}




if (isset($update["result"]["action"]))
{


     processMessage();
}






?>
