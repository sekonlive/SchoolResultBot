<?php 

ini_set("allow_url_open", 1);
function processMessage($update) {
    
    
    if($update["result"]["action"] == "AddEntry"){
        
        $pnr = $update["result"]["parameters"]["pnr"];
        $airline = $update["result"]["parameters"]["airline"];
        $noPax = $update["result"]["parameters"]["noPax"];
        $date = $update["result"]["parameters"]["date"];
        $client = $update["result"]["parameters"]["client"];
        $client = urlencode($client);
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
                        $fdate = date("d M 18", strtotime($fdate));
                        if($StatusCode=="200"){
        sendMessage(array(
            "source" => $update["result"]["source"],
            "speech" => "Done\n-----------\nDate: ".$fdate."\nAirline: ".$fairline."\nPnr: ".$fpnr."\nNo of Pax: ".$fnoPax."\nClient: ".$fclient,
            "displayText" => "Done\n-----------\nDate: ".$fdate."\nAirline: ".$fairline."\nPnr: ".$fpnr."\nNo of Pax: ".$fnoPax."\nClient: ".$fclient,
            "contextOut" => array()
        ));
        }else{
    
            sendMessage(array(
            "source" => $update["result"]["source"],
            "speech" => "Failed\n-----------\nDate: ".$date."\nAirline: ".$airline."\nPnr: ".$pnr."\nNo of Pax: ".$noPax."\nClient: ".$client,
            "displayText" => "Failed\n-----------\nDate: ".$date."\nAirline: ".$airline."\nPnr: ".$pnr."\nNo of Pax: ".$noPax."\nClient: ".$client,
            "contextOut" => array()
        ));
            
        }
    }
    
        if($update["result"]["action"] == "Review"){
        
        $fpnr = $update["result"]["parameters"]["pnr"];
        $fpnr = urlencode($fpnr);
        $fairline = $update["result"]["parameters"]["airline"];
        $fnoPax = $update["result"]["parameters"]["noPax"];
        $fdate = $update["result"]["parameters"]["date"];
        $fclient = $update["result"]["parameters"]["client"];
        $fclient = urlencode($fclient);
        $status = "Done";
        $fdate = date("d M 18", strtotime($fdate));
        $msg1 = array("speech" => " Review  \n ----------- \n Date: ".$fdate."\n Airline: ".$fairline."\nPnr: ".$fpnr."\nNo of Pax: ".$fnoPax."\nClient: ".$fclient,
                          "type" => 0);
       // $msg2 = array("speech" => " Review 1  \n ----------- \n Date: ".$fdate."\n Airline: ".$fairline."\nPnr: ".$fpnr."\nNo of Pax: ".$fnoPax."\nClient: ".$fclient,
          //                "type" => 0,
         //               "platform" => "telegram");
            $Tcard = array("title" => " Review ",
                           "subtitle" => "\n Date: ".$fdate."\n Airline: ".$fairline."\nPnr: ".$fpnr."\nNo of Pax: ".$fnoPax."\nClient: ".$fclient,
                           "imageUrl" => "",
                           "buttons" => array(array("postback" => "" , "text" => "Okay, Proceed"),array("postback" => "" , "text" => "Cancel")),
                          "type" => 1,
                        "platform" => "telegram");
            
            //$TQuick = array("title" => "Choose",
                    //       "replies" => ["Okay, Proceed" , "Cancel"],
                     //     "type" => 2,
                      //  "platform" => "telegram");
        $messages = array($msg1,$Tcard);           
        sendMessage(array(
            "source" => $update["result"]["source"],
            "speech" => " Review  \n ----------- \n Date: ".$fdate."\n Airline: ".$fairline."\nPnr: ".$fpnr."\nNo of Pax: ".$fnoPax."\nClient: ".$fclient,
            "displayText" => "Review \n  ----------- \nDate: ".$fdate."\n Airline: ".$fairline."\nPnr: ".$fpnr."\nNo of Pax: ".$fnoPax."\nClient: ".$fclient,
            "contextOut" => array(),
            "messages" => $messages
        ));
        
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
