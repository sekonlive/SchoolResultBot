<?php 

ini_set("allow_url_open", 1);
function processMessage($update) {
    
    
    if($update["result"]["action"] == "AddEntry"){
        
        $pnr = $update["result"]["parameters"]["pnr"];
        $airline = $update["result"]["parameters"]["airline"];
        $noPax = $update["result"]["parameters"]["noPax"];
        $date = $update["result"]["parameters"]["date"];
        $client = $update["result"]["parameters"]["client"];
        $status = "Done";
        
        
        $EntryUrl="http://manage.otb-network.com/application/GETProcessing.php?PNR=".$pnr."&airline=".$airline."&no_pax=".$noPax."&client=".$client."&status=".$status."&date=".$date;
                        $content=file_get_contents($EntryUrl);
                        $Obj=json_decode($content, true);
                        $StatusCode=$Obj['StatusCode'];
                        $fpnr = $Obj["pnr"];
                        $fairline = $Obj["airline"];
                        $fnoPax = $Obj["noPax"];
                        $fdate = $Obj["date"];
                        $fclient = $Obj["client"];
                        if($StatusCode=="200"){
        sendMessage(array(
            "source" => $update["result"]["source"],
            "speech" => "Done\n-----------\nDate: ".$date."\nAirline: ".$fairline."\nPnr: ".$fpnr."\nNo of Pax: ".$fnoPax."\nClient: ".$fclient,
            "displayText" => "Done\n-----------\nDate: ".$date."\nAirline: ".$fairline."\nPnr: ".$fpnr."\nNo of Pax: ".$fnoPax."\nClient: ".$fclient,
            "contextOut" => array()
        ));
        }else{
            $Card=array("platform" => "telegram", "title" => "DataBase Updated","subtitle" => "Test","imageUrl" => "" "type"=>1);
            sendMessage(array(
            "source" => $update["result"]["source"],
            "speech" => "Failed\n-----------\nDate: ".$date."\nAirline: ".$airline."\nPnr: ".$pnr."\nNo of Pax: ".$noPax."\nClient: ".$client,
            "displayText" => "Failed\n-----------\nDate: ".$date."\nAirline: ".$airline."\nPnr: ".$pnr."\nNo of Pax: ".$noPax."\nClient: ".$client,
            "contextOut" => array(),
            "messages" => $Card
        ));
            
        }
    }
}
 
function sendMessage($parameters) {
    header('Content-type: application/json');
    echo json_encode($parameters);
}
 
$update_response = file_get_contents("php://input");
$update = json_decode($update_response, true);
if (isset($update["result"]["action"])) {
    processMessage($update);
}
?>
