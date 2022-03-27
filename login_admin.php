<?php
  include("mysql.inc.php");
  session_start();
 


  //執行登出動作
  if(isset($_GET["logout"]) && ($_GET["logout"]=="true")){
	unset($_SESSION["loginMember"]);
	header("Location:home.php");
  }

?>