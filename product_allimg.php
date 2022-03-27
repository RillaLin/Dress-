<?php
	include("mysql.inc.php");
	session_start();

	/*---抓取tablename的內容，若未定義會出錯---*/
	// $tablename = $_SESSION["tablename"];
	// $img = $_SESSION["img"];

	$li = $_REQUEST['limit'];
	$class=$_REQUEST["class"];

	$sql = "SELECT pimg FROM product WHERE pclass='$class' LIMIT $li";
	// echo $sql;
	$result = mysqli_query($conn,$sql);

	while($row = mysqli_fetch_array($result)){
		header("Content-Type: image/jpg");
		echo base64_decode($row['pimg']);
	}
                                
?>