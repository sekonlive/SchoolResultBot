<?php 
function processMessage($update) {
    
    
    if($update["result"]["action"] == "AddEntry"){
        
        $pnr = $update["result"]["parameters"]["pnr"];
        sendMessage(array(
            "source" => $update["result"]["source"],
            "speech" => "Hello from ".$pnr,
            "displayText" => "Hello from ".$pnr,
            "contextOut" => array()
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
