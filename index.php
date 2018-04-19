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
                        $Success = array("speech" => " Success \n ----------- \n Date: ".$fdate."\n Airline: ".$fairline."\nPnr: ".$fpnr."\nNo of Pax: ".$fnoPax."\nClient: ".$fclient,
                          "type" => 0);
                        $TSuccess = array("title" => " Success",
                           "subtitle" => "Date: ".$fdate."\n Airline: ".$fairline."\nPnr: ".$fpnr."\nNo of Pax: ".$fnoPax."\nClient: ".$fclient,
                           "imageUrl" => "http://www.acemetrix.com/wp-content/themes/acemetrix/images/video/green_purple/green_bg.jpg",
                           "buttons" => array(array("postback" => "" , "text" => "New Entry")),
                          "type" => 1,
                        "platform" => "telegram");
                        $messages = array($Success,$TSuccess);
                        if($StatusCode=="200"){
        sendMessage(array(
            "source" => $update["result"]["source"],
            "speech" => "Done\n-----------\nDate: ".$fdate."\nAirline: ".$fairline."\nPnr: ".$fpnr."\nNo of Pax: ".$fnoPax."\nClient: ".$fclient,
            "displayText" => "Done\n-----------\nDate: ".$fdate."\nAirline: ".$fairline."\nPnr: ".$fpnr."\nNo of Pax: ".$fnoPax."\nClient: ".$fclient,
            "contextOut" => array(),
            "resetContexts" => True,
            "messages" => $messages
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
    
    
    if($update["result"]["action"] == "AddTicket"){
        
        $Date = $update["result"]["parameters"]["Date"];
        $Cost = $update["result"]["parameters"]["Cost"];
        $Sell = $update["result"]["parameters"]["Sell"];
        $NoPax = $update["result"]["parameters"]["NoPax"];
        
        
        $EntryUrl="http://manage.otb-network.com/application/TicketAdd.php?Date=".$Date."&Cost=".$Cost."&Sell=".$Sell."&NoPax=".$NoPax;
                        
                        $content=file_get_contents($EntryUrl);
                        $Obj=json_decode($content, true);
                        $StatusCode=$Obj['StatusCode'];
                        $fDate = $Obj["Date"];
                        $fCost = $Obj["Cost"];
                        $fSell = $Obj["Sell"];
                        $fNoPax = $Obj["NoPax"];
                        $fDate = date("d M Y", strtotime($fDate));
                        $Success = array("speech" => " Success \n ----------- \n Date: ".$fDate."\n Cost: ".$fCost."\nPnr: ".$fSell."\nNo of Pax: ".$fNoPax,
                          "type" => 0);
                        $TSuccess = array("title" => " Success",
                           "subtitle" => "Date: ".$fDate."\n Cost: ".$fCost."\nPnr: ".$fSell."\nNo of Pax: ".$fNoPax,
                           "imageUrl" => "http://www.acemetrix.com/wp-content/themes/acemetrix/images/video/green_purple/green_bg.jpg",
                           "buttons" => array(array("postback" => "" , "text" => "New Entry")),
                          "type" => 1,
                        "platform" => "telegram");
                        $messages = array($Success,$TSuccess);
                        if($StatusCode=="200"){
        sendMessage(array(
            "source" => $update["result"]["source"],
            "speech" => "Done\n-----------\nDate: ".$fDate."\n Cost: ".$fCost."\nPnr: ".$fSell."\nNo of Pax: ".$fNoPax,
            "displayText" => "Done\n-----------\nDate: ".$fDate."\n Cost: ".$fCost."\nPnr: ".$fSell."\nNo of Pax: ".$fNoPax,
            "contextOut" => array(),
            "resetContexts" => True,
            "messages" => $messages
        ));
        }else if($StatusCode=="400"){
    
            sendMessage(array(
            "source" => $update["result"]["source"],
            "speech" => "Failed\n-----------\nDate: ".$fDate."\n Cost: ".$fCost."\nPnr: ".$fSell."\nNo of Pax: ".$fNoPax,
            "displayText" => "Failed\n-----------\nDate: ".$fDate."\n Cost: ".$fCost."\nPnr: ".$fSell."\nNo of Pax: ".$fNoPax,
            "contextOut" => array()
        ));
            
        }
       
    }
    
    if($update["result"]["action"] == "TicketDaily"){
        
        $Date = $update["result"]["parameters"]["Date"];
        
        
        
        $fetchData="http://manage.otb-network.com/application/API/TicketDaily.php?Date=".$Date;
                        
                        $content=file_get_contents($fetchData);
                        $Obj=json_decode($content, true);
                        $StatusCode=$Obj['StatusCode'];
                        $fErrorType = $Obj["ErrorType"];
                        $fDate = $Obj["Date"];
                        $fCost = $Obj["Cost"];
                        $fSell = $Obj["Sell"];
                        $fNoPax = $Obj["NoPax"];
                        $fDate = date("d M y", strtotime($fDate));
                        $Success = array("speech" => " Daily Report \n ----------- \n Date: ".$fDate."\n Cost: ".$fCost."\nPnr: ".$fSell."\nNo of Pax: ".$fNoPax,
                          "type" => 0);
                        $TSuccess = array("title" => " Daily Report ",
                           "subtitle" => "Date: ".$fDate."\n Cost: ".$fCost."\nPnr: ".$fSell."\nNo of Pax: ".$fNoPax,
                           "buttons" => array(array("postback" => "" , "text" => "New Entry")),
                          "type" => 1,
                        "platform" => "telegram");
                        $messages = array($Success,$TSuccess);
                        if($fErrorType=="200"){
        sendMessage(array(
            "source" => $update["result"]["source"],
            "speech" => "Daily Report Daily Report \n-----------\nDate: ".$fDate."\n Cost: ".$fCost."\nPnr: ".$fSell."\nNo of Pax: ".$fNoPax,
            "displayText" => "Daily Report \n-----------\nDate: ".$fDate."\n Cost: ".$fCost."\nPnr: ".$fSell."\nNo of Pax: ".$fNoPax,
            "contextOut" => array(),
            "resetContexts" => True,
            "messages" => $messages
        ));
        }else{
    
            sendMessage(array(
            "source" => $update["result"]["source"],
            "speech" => "Daily Report\n-----------\nDate: ".$fDate."\n No Entry Founded",
            "displayText" => "Daily Report\n-----------\nDate: ".$fDate."\n No Entry Founded",
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
                           "subtitle" => "Date: ".$fdate."\n Airline: ".$fairline."\nPnr: ".$fpnr."\nNo of Pax: ".$fnoPax."\nClient: ".$fclient,
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
