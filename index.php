<?php 
ini_set("allow_url_open", 1);
function ReternZero($num)
{
    if($num==null)
        return 0;
    else
        return $num;
}
function processMessage($update) {
    
    
        $LogStatus="NoData";
    $Action=$update["result"]["action"];
    $LogStatus = $update["result"]["contexts"][0]["parameters"]["LogStatus"];
    switch($Action){
            
            
        case "VisaClientEntry":
                                if($LogStatus=="Success"){
                                    
                                    $Date = $update["result"]["parameters"]["Date"];
                                    $Client = $update["result"]["parameters"]["Client"];
                                    $VisaType = $update["result"]["parameters"]["VisaType"];
                                    $Quantity = $update["result"]["parameters"]["Quantity"];
                                    $Client= urlencode($Client);
                                    $VisaType= urlencode($VisaType);
                        
                                    $EntryUrl="http://manage.otb-network.com/application/VisaClientEntry.php?Date=".$Date."&Client=".$Client."&VisaType=".$VisaType."&Quantity=".$Quantity;
                        
                                    $content=file_get_contents($EntryUrl);
                                    $Obj=json_decode($content, true);
                                    $StatusCode=$Obj['StatusCode'];
                                    $fDate = $Obj["date"];
                                    $fClient = $Obj["Client"];
                                    $fVisaType = $Obj["VisaType"];
                                    $fQuantity = $Obj["Quantity"];
                                    $fDate = date("d M Y", strtotime($fDate));
                                    $Success = array("speech" => " Saved Successfully \n \n Date: ".$fDate."\nClient: ".$fClient."\nVisa Type: ".$fVisaType."\nQuantity: ".$fQuantity,
                                    "type" => 0);
                                    $TSuccess = array("title" => " Saved Successfully ",
                                    "subtitle" => "Date: ".$fDate."\nClient: ".$fClient."\nVisa Type: ".$fVisaType."\nQuantity: ".$fQuantity,
                                    "imageUrl" => "",
                                    "buttons" => array(),
                                    "type" => 1,
                                    "platform" => "telegram");
                                    $messages = array($Success,$TSuccess);
                                    if($StatusCode=="200"){
                                        sendMessage(array("source" => $update["result"]["source"],"speech" => " Saved Successfully \n \n Date:  ".$fDate."\nClient: ".$fClient."\nVisa Type: ".$fVisaType."\nQuantity: ".$fQuantity,"displayText" => " Saved     Successfully \n \n Date: ".$fDate."\nClient: ".$fClient."\nVisa Type: ".$fVisaType."\nQuantity:     ".$fQuantity,"contextOut" => array(),"resetContexts" => True,"messages" => $messages));
                                    }
                                    else if($StatusCode=="400"){
    
                                        sendMessage(array(
                                        "source" => $update["result"]["source"],
                                        "speech" => "Saving failed, Please try again",
                                        "displayText" => "Saving failed, Please try again",
                                        "contextOut" => array()
                                        ));
            
                                    }
                                }
                                else{
                                    
                                    $messages = array("title" => " Login required ",
                                    "subtitle" => "Please Log in to Access this section.","imageUrl" => "",
                                    "buttons" => array(array("postback" => "" , "text" => "Log in"),array("postback" => "" , "text" => "Cancel")),
                                    "type" => 1,
                                    "platform" => "telegram");
                                    sendMessage(array(
                                    "source" => $update["result"]["source"],
                                    "speech" => "Please Log in to Access this section.",
                                    "displayText" => "Please Log in to Access this section.",
                                    "messages" => array($messages)
                                    )); 
             
                                }
                                break;
        
        case "SignOn":          $Username = $update["result"]["parameters"]["username"];
                                $Pin = $update["result"]["parameters"]["Pin"];
                                if($Username=="Shihab" && $Pin==1234 ){
                                    sendMessage(array(
                                    "source" => $update["result"]["source"],
                                    "speech" => "Sign On Successfully ",
                                    "displayText" => "Sign On Successfully ",
                                    "contextOut" => array(array("name"=>"Log","lifespan"=>8, "parameters"=>array("LogStatus"=>"Success")))
                                    ));
                                }else{
                                    sendMessage(array(
                                    "source" => $update["result"]["source"],
                                    "speech" => "Pin not match ",
                                    "displayText" => "Pin not match ",
                                    "contextOut" => array(array("name"=>"Log","lifespan"=>8, "parameters"=>array("LogStatus"=>"Error")))
                                    ));
                                }
                                break;  
            
        case "SignOut":                    
                                sendMessage(array(
                                "source" => $update["result"]["source"],
                                "speech" => "Sign Out Successfully ",
                                "displayText" => "Sign Out Successfully ",
                                "contextOut" => array(array("name"=>"Log","lifespan"=>8, "parameters"=>array("LogStatus"=>"NoUser")))
                                ));
                                break;
            
        case "AddEntry":                
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
                                "subtitle" => "Date: ".$fdate."\nAirline: ".$fairline."\nPnr: ".$fpnr."\nNo of Pax: ".$fnoPax."\nClient: ".$fclient,
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
                                    "displayText" => "Failed\n-----------\nDate: ".$date."\nAirline: ".$airline."\nPnr: ".$pnr."\nNo of Pax: ".$noPax."\nClient:                        ".$client,
                                    "contextOut" => array()
                                    ));
            
                                }
                                break;
                   
        case "VisaVendorEntry":                
                                $Date = $update["result"]["parameters"]["Date"];
                                $Vendor = $update["result"]["parameters"]["Vendor"];
                                $VisaType = $update["result"]["parameters"]["VisaType"];
                                $Quantity = $update["result"]["parameters"]["Quantity"];
                                $Vendor= urlencode($Vendor);
                                $VisaType= urlencode($VisaType);
        
                                $EntryUrl="http://manage.otb-network.com/application/VisaVendorEntry.php?                       Date=".$Date."&Vendor=".$Vendor."&VisaType=".$VisaType."&Quantity=".$Quantity;
                        
                                $content=file_get_contents($EntryUrl);
                                $Obj=json_decode($content, true);
                                $StatusCode=$Obj['StatusCode'];
                                $fDate = $Obj["Date"];
                                $fVendor = $Obj["Vendor"];
                                $fVisaType = $Obj["VisaType"];
                                $fQuantity = $Obj["Quantity"];
                                $fDate = date("d M Y", strtotime($fDate));
                                $Success = array("speech" => " Saved Successfully \n \n Date: ".$fDate."\nVendor: ".$fVendor."\nVisa Type: ".$fVisaType."\nQuantity: ".$fQuantity,
                                "type" => 0);
                                $TSuccess = array("title" => " Saved Successfully ",
                                "subtitle" => "Date: ".$fDate."\nVendor: ".$fVendor."\nVisa Type: ".$fVisaType."\nQuantity: ".$fQuantity,
                                "imageUrl" => "",
                                "buttons" => array(),
                                "type" => 1,
                                "platform" => "telegram");
                                $messages = array($Success,$TSuccess);
                                if($StatusCode=="200"){
                                    sendMessage(array(
                                    "source" => $update["result"]["source"],
                                    "speech" => " Saved Successfully \n \n Date: ".$fDate."\nVendor: ".$fVendor."\nVisa Type: ".$fVisaType."\nQuantity: ".$fQuantity,
                                    "displayText" => " Saved Successfully \n \n Date: ".$fDate."\nVendor: ".$fVendor."\nVisa Type: ".$fVisaType."\nQuantity:                        ".$fQuantity,
                                    "contextOut" => array(),
                                    "resetContexts" => True,
                                    "messages" => $messages
                                    ));
                                }else if($StatusCode=="400"){
    
                                    sendMessage(array(
                                    "source" => $update["result"]["source"],
                                    "speech" => "Saving failed, Please try again",
                                    "displayText" => "Saving failed, Please try again",
                                    "contextOut" => array()
                                    ));
            
                                }
       
                                break;
                          
        case "TicketDaily":                
                                        
                                $LogStatus = $update["result"]["contexts"][0]["parameters"]["LogStatus"];
                                if($LogStatus=="Success"){
                                    $Date = $update["result"]["parameters"]["Date"];
                                    $fetchData="http://manage.otb-network.com/application/API/TicketDaily.php?Date=".$Date;         
                                    $content=file_get_contents($fetchData);
                                    $Obj=json_decode($content, true);
                                    $StatusCode=$Obj['StatusCode'];
                                    $fErrorType = $Obj["ErrorType"];
                                    $fDate = $Obj["Date"];
                                    $fCost = $Obj["Cost"];
                                    $fSell = $Obj["Sell"];
                                    $fProfit = $fSell-$fCost;
                                    $fNoPax = $Obj["NoPax"];
                                    $fDate = date("d M y", strtotime($fDate));
                                    $Success = array("speech" => " Daily Report \n ----------- \nDate: ".$fDate."\nCost: ₹".$fCost."\n*Quoted price:* ₹".$fSell."\nProfit: ₹".$fProfit."\nNo of Pax: ".$fNoPax,
                                    "type" => 0);
                                    $TSuccess = array("title" => " Daily Report ",
                                    "subtitle" => "\nDate: ".$fDate."\nCost: ₹".$fCost."\n*Quoted price*: ₹".$fSell."\nProfit: ₹".$fProfit."\nNo of Pax: ".$fNoPax,
                                    "buttons" => array(),
                                    "type" => 1,
                                    "platform" => "telegram");
                                    $messages = array($Success,$TSuccess);
                                    if($fErrorType=="200"){
                                        sendMessage(array(
                                        "source" => $update["result"]["source"],
                                        "speech" => "Daily Report Daily Report \n-----------\nDate: ".$fDate."\nCost: ₹".$fCost."\n*Quoted price*: ₹".$fSell."\nProfit: ₹".$fProfit."\nNo of Pax: ".$fNoPax,
                                        "displayText" => "Daily Report \n-----------\nDate: ".$fDate."\nCost: ₹".$fCost."\n*Quoted price*: ₹".$fSell."\nProfit: ₹".$fProfit."\nNo of Pax: ".$fNoPax,
                                        "contextOut" => array(array("name"=>"Log","lifespan"=>8, "parameters"=>array("LogStatus"=>"Success"))),
                                         "parse_mode"=> "Markdown",
                                        "messages" => $messages
                                        ));
                                    }else{
    
                                        sendMessage(array(
                                        "source" => $update["result"]["source"],
                                        "speech" => "`No Entry Founded on` ".$fDate.$_SESSION["status"],
                                        "displayText" => "`No Entry Founded on` ".$fDate.$_SESSION["status"],
                                        "parse_mode"=> "Markdown",
                                        "contextOut" => array(array("name"=>"Log","lifespan"=>8, "parameters"=>array("LogStatus"=>"Success")))
                                        ));
                                    }
                                }else{
                                    $messages = array("title" => " Login required ",
                                    "subtitle" => "Please Log in to Access Daily Sales report.","imageUrl" => "",
                                    "buttons" => array(array("postback" => "" , "text" => "Log in"),array("postback" => "" , "text" => "Cancel")),
                                    "type" => 1,
                                    "platform" => "telegram");
                                    sendMessage(array(
                                    "source" => $update["result"]["source"],
                                    "speech" => "Please Log in to Access Daily Sales report.",
                                    "displayText" => "Please Log in to Access Daily Sales report.",
                                    "messages" => array($messages)
                                    )); 
             
                                } 
            
                                
                                break;
                                 
        case "AddTicket": 
                            $LogStatus = $update["result"]["contexts"][0]["parameters"]["LogStatus"];
                            if($LogStatus=="Success"){               
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
                                $Success = array("speech" => " Success \n ----------- \n Date: ".$fDate."\nCost: ".$fCost."\nPnr: ".$fSell."\nNo of Pax: ".$fNoPax,
                                "type" => 0);
                                $TSuccess = array("title" => " Success",
                                "subtitle" => "Date: ".$fDate."\nCost: ".$fCost."\nQuoted price: ".$fSell."\nNo of Pax: ".$fNoPax,
                                "imageUrl" => "",
                                "buttons" => array(array("postback" => "" , "text" => "New Ticket")),
                                "type" => 1,
                                "platform" => "telegram");
                                $messages = array($Success,$TSuccess);
                                if($StatusCode=="200"){
                                    sendMessage(array(
                                    "source" => $update["result"]["source"],
                                    "speech" => "Done\n-----------\nDate: ".$fDate."\nCost: ".$fCost."\nQuoted price: ".$fSell."\nNo of Pax: ".$fNoPax,"displayText" => "Done\n-----------\nDate: ".$fDate."\nCost: ".$fCost."\nQuoted price: ".$fSell."\nNo of Pax: ".$fNoPax,"contextOut" => array(),"resetContexts" => True,"messages" => $messages
                                    ));
                                }else if($StatusCode=="400"){
                                    sendMessage(array(
                                    "source" => $update["result"]["source"],
                                    "speech" => "Failed\n-----------\nDate: ".$fDate."\nCost: ".$fCost."\nQuoted price: ".$fSell."\nNo of Pax: ".$fNoPax,"displayText" => "Failed\n-----------\nDate: ".$fDate."\nCost: ".$fCost."\nQuoted priceQuoted price: ".$fSell."\nNo of Pax: ".$fNoPax,"contextOut" => array()
                                    ));
                
                                }
                        }else{
                            $messages = array("title" => " Login required ",
                            "subtitle" => "Please Log in to Access Daily Sales report.","imageUrl" => "",
                            "buttons" => array(array("postback" => "" , "text" => "Log in"),array("postback" => "" , "text" => "Cancel")),
                            "type" => 1,
                            "platform" => "telegram");
                            sendMessage(array(
                            "source" => $update["result"]["source"],
                            "speech" => "Please Log in to Access Daily Sales report.",
                            "displayText" => "Please Log in to Access Daily Sales report.",
                            "messages" => array($messages)
                            )); 
             
                        } 
            
                                break;
       
                                         
        case "Review":                
                            $fpnr = $update["result"]["parameters"]["pnr"];
                            $fpnr = urlencode($fpnr);
                            $fairline = $update["result"]["parameters"]["airline"];
                            $fnoPax = $update["result"]["parameters"]["noPax"];
                            $fdate = $update["result"]["parameters"]["date"];
                            $fclient = $update["result"]["parameters"]["client"];
                            $fclient = urlencode($fclient);
                            $status = "Done";
                            $fdate = date("d M 18", strtotime($fdate));
                            $msg1 = array("speech" => " Review  \n ----------- \nDate: ".$fdate."\n Airline: ".$fairline."\nPnr: ".$fpnr."\nNo of Pax: ".$fnoPax."\nClient: ".$fclient,
                            "type" => 0);

                            $Tcard = array("title" => " Review ",
                            "subtitle" => "Date: ".$fdate."\nAirline: ".$fairline."\nPnr: ".$fpnr."\nNo of Pax: ".$fnoPax."\nClient: ".$fclient,
                            "imageUrl" => "",
                            "buttons" => array(array("postback" => "" , "text" => "Okay, Proceed"),array("postback" => "" , "text" => "Cancel")),
                            "type" => 1,
                            "platform" => "telegram");
        
                            $messages = array($msg1,$Tcard);           
                            sendMessage(array(
                            "source" => $update["result"]["source"],
                            "speech" => " Review  \n ----------- \nDate: ".$fdate."\nAirline: ".$fairline."\nPnr: ".$fpnr."\nNo of Pax: ".$fnoPax."\nClient: ".$fclient,
                            "displayText" => "Review \n  ----------- \nDate: ".$fdate."\nAirline: ".$fairline."\nPnr: ".$fpnr."\nNo of Pax: ".$fnoPax."\nClient: ".$fclient,
                            "contextOut" => array(),
                            "messages" => $messages
                            ));
                                break;
                                                
        case "TicketMonthly":                
                            $LogStatus = $update["result"]["contexts"][0]["parameters"]["LogStatus"];
                            if($LogStatus=="Success"){
                                $Date = $update["result"]["parameters"]["Date"];
                                $fetchData="http://manage.otb-network.com/application/API/TicketMonth.php?Date=".$Date;
                                $content=file_get_contents($fetchData);
                                $Obj=json_decode($content, true);
                                $fErrorType = $Obj["ErrorType"];
                                $fErrorMessage = $Obj["ErrorMessage"];
                                $fsDate = $Obj["sDate"];
                                $feDate = $Obj["eDate"];
                                $fCost = $Obj["Cost"];
                                $fSell = $Obj["Sell"];
                                $fProfit = $fSell-$fCost;
                                $fNoPax = $Obj["NoPax"];
                                $fsDate = date("d M ", strtotime($fsDate));
                                $feDate = date("d M Y", strtotime($feDate));
                                $Success = array("speech" => " Report \n ----------- \n Period: ".$fsDate." - ".$feDate."\n*Cost:* ₹".$fCost."\n*Quoted price:* ₹".$fSell."\n*Profit: ₹".$fProfit."\n*No of Pax:* ".$fNoPax,
                                "type" => 0);
                                $TSuccess = array("title" => " Report ",
                                "subtitle" => "*Period:* ".$fsDate." - ".$feDate."\n*Cost:* ₹".$fCost."\n*Quoted price:* ₹".$fSell."\n*Profit:* ₹".$fProfit."\n*No of Pax:* ".$fNoPax,
                                "buttons" => array(),
                                "type" => 1,
                                "platform" => "telegram");
                                $messages = array($Success,$TSuccess);
                                if($fErrorType=="200"){
                                    sendMessage(array(
                                    "source" => $update["result"]["source"],
                                    "speech" => "*Report* \n-----------\nReport \n ----------- \n*Period:* ".$fsDate." - ".$feDate."\n*Cost:* ₹".$fCost."\n*Quoted price:* ₹".$fSell."\nProfit: ₹".$fProfit."\n*No of Pax:* ".$fNoPax,
                                    "displayText" => "*Report* \n ----------- \n*Period:* ".$fsDate." - ".$feDate."\n*Cost:* ₹".$fCost."\n*Quoted price:* ₹".$fSell."\n*Profit:* ₹".$fProfit."\n*No of Pax:* ".$fNoPax,
                                    "contextOut" => array(array("name"=>"Log","lifespan"=>8, "parameters"=>array("LogStatus"=>"Success"))),
                                    "parse_mode"=> "Markdown",
                                    "messages" => $messages
                                    ));
                                }else{
    
                                    sendMessage(array(
                                    "source" => $update["result"]["source"],
                                    "speech" => "Report\n-----------\nPeriod: ".$fsDate." - ".$feDate."\n No Entry Founded",
                                    "displayText" => "Report\n-----------\nPeriod: ".$fsDate." - ".$feDate."\n No Entry Founded",
                                    "contextOut" => array(array("name"=>"Log","lifespan"=>8, "parameters"=>array("LogStatus"=>"Success")))
                                    ));
            
                                }
                            }
                            else{
                                $messages = array("title" => " Login required ",
                                "subtitle" => "Please Log in to Access Monthly Sales report.","imageUrl" => "",
                                "buttons" => array(array("postback" => "" , "text" => "Log in"),array("postback" => "" , "text" => "Cancel")),
                                "type" => 1,
                                "platform" => "telegram");
                                sendMessage(array(
                                "source" => $update["result"]["source"],
                                "speech" => "Please Log in to Access Monthly Sales report.",
                                "displayText" => "Please Log in to Access Monthly Sales report.",
                                "messages" => array($messages)
                                )); 
             
                            }
                                break;  
            
        case "VisaDSR":     $LogStatus = $update["result"]["contexts"][0]["parameters"]["LogStatus"];
                            if($LogStatus=="Success"){
                                $Date = $update["result"]["parameters"]["Date"];
                                $fetchData="http://manage.otb-network.com/application/API/DSR_Visa.php?Date=".$Date;
                                $content=file_get_contents($fetchData);
                                $Obj=json_decode($content, true);
                                $fErrorType = $Obj["ErrorType"];
                                $fErrorMessage = $Obj["ErrorMessage"];
                                $fDate = $Obj["Date"];
                                $LTD = ReternZero($Obj["LTD"]);
                                $STD = ReternZero($Obj["STD"]);
                                $LTA = ReternZero($Obj["LTA"]);
                                $fDate = date("d M y", strtotime($fDate));
                                $EC=count($Obj["Data"]);
                                for($i=0;$i<$EC;$i++)
                                    $Expanded+="*".$Obj["Data"][$i]["Name"]."*\n*LTD:* ".$Obj["Data"][$i]["LTD"]."*\n*LTA:* ".$Obj["Data"][$i]["LTA"]."*\n*STD:* ".$Obj["Data"][$i]["STD"]."\n\n";
                                $Success = array("speech" => " DSR - VISA \n ----------- \n Date: ".$fDate."\n*Long Term DXB:*  ".$LTD."\n*Long Term AUH:* ".$LTA."\n*Short Term DXB: ".$STD,
                                "type" => 0);
                                $TSuccess = array("title" => "DSR - VISA",
                                "subtitle" => "*Date:* ".$fDate."\n*Long Term DXB:* ".$LTD."\n*Long Term AUH:* ".$LTA."\n*Short Term DXB:* ".$STD."\n".$Expanded,
                                "buttons" => array(array("postback" => "" , "text" => "Expand")),
                                "type" => 1,
                                "platform" => "telegram");
                                $messages = array($TSuccess,$Success);
                                if($fErrorType=="200"){
                                    sendMessage(array(
                                    "source" => $update["result"]["source"],
                                    "speech" => "*DSR - VISA * \n-----------\nReport \n ----------- \nDate: ".$fDate."\n*Long Term DXB:*  ".$LTD."\n*Long Term AUH:* ".$LTA."\n*Short Term DXB: ".$STD,
                                    "displayText" => "*DSR - VISA * \n ----------- \nDate: ".$fDate."\n*Long Term DXB:*  ".$LTD."\n*Long Term AUH:* ".$LTA."\n*Short Term DXB: ".$STD,
                                    "contextOut" => array(array("name"=>"Log","lifespan"=>8, "parameters"=>array("LogStatus"=>"Success"))),
                                    "parse_mode"=> "Markdown",
                                    "messages" => $messages
                                    ));
                                }else{
    
                                    sendMessage(array(
                                    "source" => $update["result"]["source"],
                                    "speech" => "DSR - VISA \n ----------- \n Date: ".$fDate."\n No Entry Founded",
                                    "displayText" => "DSR - VISA \n ----------- \n Date: ".$fDate."\n No Entry Founded",
                                    "contextOut" => array(array("name"=>"Log","lifespan"=>8, "parameters"=>array("LogStatus"=>"Success")))
                                    ));
            
                                }
                            }
                            else{
                                $messages = array("title" => " Login required ",
                                "subtitle" => "Please Log in to Access Monthly Sales report.","imageUrl" => "",
                                "buttons" => array(array("postback" => "" , "text" => "Log in"),array("postback" => "" , "text" => "Cancel")),
                                "type" => 1,
                                "platform" => "telegram");
                                sendMessage(array(
                                "source" => $update["result"]["source"],
                                "speech" => "Please Log in to Access Daily Sales report.",
                                "displayText" => "Please Log in to Access Daily Sales report.",
                                "messages" => array($messages)
                                )); 
             
                            }           
                                
                                break;  
            
        case "#":                
                                
                                break;
       
        
        default:
                                sendMessage(array(
                                "source" => $update["result"]["source"],
                                "speech" => "Action Could not find on server! ",
                                "displayText" => "Action Could not find on server! ",
                                "contextOut" => array(array("name"=>"Log","lifespan"=>8, "parameters"=>array("LogStatus"=>"Success")))
                                ));
                                break;
        
            
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
