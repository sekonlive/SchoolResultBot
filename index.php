<?php
function processMessage()
{

    switch($actionName)
    {
        case 'weather' :   $speech = "Weather in Payyoli : Clear sky, 29 deg c ";
                        $displayText = "Weather in Payyoli : Clear sky, 29 deg c ";
                        $source = "weather";
                        break;
        case 'sslcResult' :   $speech = "Congrats, You are eligible for higher studies. ";
                        $displayText = "Congrats, You are eligible for higher studies.";
                        $source = "sslcResult";
                        break;
            default :   $speech = $city."fdytf";
                        $displayText = $actionName."jhfjf";
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



$response = file_get_contents("php://input");
$update = json_decode($response, true);
if (isset($update["result"]["action"]))
{
    $actionName=$update["result"]["action"];
    $city = $update["result"]["geo-city"];
     processMessage();
}






?>
