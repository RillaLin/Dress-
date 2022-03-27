<?php

   include("mysql.inc.php");
	session_start();

	/*---抓取tablename的內容，若未定義會出錯---*/
	$tablename = $_SESSION["tablename"];

	$li = $_REQUEST['limit2'];

    if( !empty($_SESSION["img_id2"])){
		if($_SESSION["img_id2"]=='home3'){
			$sql = "SELECT pimg FROM $tablename WHERE psprice > poprice ORDER BY poprice LIMIT $li";
		}
	
	    $result = mysqli_query($conn,$sql);
 
	    while($row = mysqli_fetch_array($result)){
		    header("Content-Type: image/jpg");
		    echo base64_decode($row['pimg']);
	    }
	}

?>