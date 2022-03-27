<?php

   include("mysql.inc.php");
	session_start();

	/*---抓取tablename的內容，若未定義會出錯---*/
	$tablename = $_SESSION["tablename"];

	$li = $_REQUEST['limit1'];

    if( !empty($_SESSION["img_id1"])){
		if($_SESSION["img_id1"]=='home1'){
			$sql = "SELECT pimg FROM $tablename ORDER BY pdate DESC LIMIT $li";
		}
	
	    $result = mysqli_query($conn,$sql);
 
	    while($row = mysqli_fetch_array($result)){
		    header("Content-Type: image/jpg");
		    echo base64_decode($row['pimg']);
	    }
	}

?>