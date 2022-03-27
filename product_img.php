<?php
	include("mysql.inc.php");
	session_start();

	/*---抓取tablename的內容，若未定義會出錯---*/
	// $img = $_SESSION["img"];
	$pid = $_REQUEST['pid'];
	$sid = $_REQUEST['sid'];

	$sql = "SELECT pimg FROM product WHERE pid=$pid AND sid=$sid";
	$result = mysqli_query($conn,$sql);

	while($row = mysqli_fetch_array($result)){
		header("Content-Type: image/jpg");
		echo base64_decode($row['pimg']);
	}

?>