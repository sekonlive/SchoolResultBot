<?php
ini_set("allow_url_open", 1);
$response = file_get_contents("php://input");
$update = json_decode($response, true);
function processMessage()
{
$response = file_get_contents("php://input");
$update = json_decode($response, true);
 $actionName=$update["result"]["action"];
   
    $pnr = $update["result"]["parameters"]["PNR"];
    $pax = $update["result"]["parameters"]["NoPax"];
    $date = $update["result"]["parameters"]["date"];
    $Airline = $update["result"]["parameters"]["Airline"];
    $Client = $update["result"]["parameters"]["Client"];
    $status = "Done";
    switch($actionName)
    {
        
           case 'AddEntry'   : 
                          
                        
//                        $getStatusUrl="http://manage.otb-network.com/application/GETProcessing.php?PNR=".$pnr."&airline=".$Airline."&no_pax=".$pax."&client=".$Client."&status=".$status."&date=".$date;
//                        $content=file_get_contents($getStatusUrl);
//                        $Obj=json_decode($content, true);
//                        $StatusCode=$Obj['StatusCode'];
//                        if($StatusCode=="200"){
//                            $speech = "Done \n ---------- \n  Airline: ".$Airline." \n PNR: ".$pnr."\n Pax: ".$pax."\n Client: ".$Client;
//                            $displayText = "Done \n ---------- \n  Airline: ".$Airline." \n PNR: ".$pnr."\n Pax: ".$pax."\n Client: ".$Client;
//                        }else{
//                            $speech = "Failed \n ---------- \n  Airline: ".$Airline." \n PNR: ".$pnr."\n Pax: ".$pax."\n Client: ".$Client;
//                            $displayText = "Failed \n ---------- \n  Airline: ".$Airline." \n PNR: ".$pnr."\n Pax: ".$pax."\n Client: ".$Client;
//                        }
            $speech = "TEST";
            $displayText = "Test";
                        $source = "OTBNetwork";
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

    © 2018 GitHub, Inc.
