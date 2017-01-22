<?php
if (isset($_POST["regId"]) && isset($_POST["message"])) {
    $regId = $_POST["regId"];
    $message = $_POST["message"];
     
    include_once './GCM.php';
     
    $gcm = new GCM();
 
    $registatoin_ids = array($regId);
    $message = array("price" => $message);
 
    $result = $gcm->send_notification($registatoin_ids, $message);
 
    echo $result;
}else if (isset($_POST["allUsers"]) && isset($_POST["message"])) {
    $message = $_POST["message"];
    $regIDS = array(); // set variable as array
    include_once './db_connect.php';
    $connect= new DB_Connect();
    $db= $connect->connect();
    $query= $db->query("SELECT gcm_regid FROM gcm_users");
  	// get all ids in while loop and insert it into $regIDS array
 	while ($row2 = $query->fetch()) {
		array_push($regIDS ,$row2['gcm_regid']);
	}
    include_once './GCM.php';
     
    $gcm = new GCM();
 
    $registatoin_ids = array($regId);
    $message = array("price" => $message);
 
    $result = $gcm->send_notification($regIDS, $message);
 
    echo $result;
}
?>
