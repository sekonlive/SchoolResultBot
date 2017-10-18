<?php
ini_set("allow_url_open", 1);
$response = file_get_contents("php://input");
$update = json_decode($response, true);

function processMessage()
{

$response = file_get_contents("php://input");
$update = json_decode($response, true);

 $actionName=$update["result"]["action"];
    $city = $update["result"]["parameters"]["geo-city"];
    $pnr = $update["result"]["parameters"]["pnr"];
    switch($actionName)
    {
        case 'weather' :   $speech = "Weather in ".$city." : Clear sky, 29°C ";
                        $displayText = "Weather in ".$city." : Clear sky, 29°C ";
                        $source = "weather";
                        break;
        case 'sslcResult' :   $speech = "Congrats, You are eligible for higher studies. ";
                        $displayText = "Congrats, You are eligible for higher studies.";
                        $source = "sslcResult";
                        break;
     case 'otbStatus'   : 
                          $getStatusUrl="http://manage.otb-network.com/application/API/Status.php?pnr=".urlencode($pnr);

      $content=file_get_contents($getBalUrl);
      
      $Obj=json_decode($content, true);
      $Status=$Obj['Status'];
      $noPax=$Obj['NoPax'];
      $Date=$Obj['Date'];
      $ErrorType=$Obj['ErrorType'];
      if($ErrorType=='200'){
                  if($Status=='Done'){
                        $speech = "OTB Updated for ".$noPax." Pax(s) against, PNR : ".$pnr;
                        $displayText = "OTB Updated for ".$noPax." Pax(s) against, PNR : ".$pnr;
                        }else if($Status=='Pending'){
                        $speech = "OTB Pending for ".$noPax." Pax(s) against, PNR : ".$pnr;
                        $displayText = "OTB Pending for ".$noPax." Pax(s) against, PNR : ".$pnr;
                  }else{
                   $speech = "OTB updation Failed for the PNR : ".$pnr;
                        $displayText ="OTB updation Failed for the PNR : ".$pnr;
                  }
      }else{
                        $speech = "OTB Request for the PNR : ".$pnr." not Found, Please check few minutes later".$Status."|".$ErrorType;
                        $displayText = "OTB Request for the PNR : ".$pnr." not Found, Please check few minutes later".$Status."|".$ErrorType;
      }
                         
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
