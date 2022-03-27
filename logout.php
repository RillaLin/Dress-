<?php
	header("Content-Type:text/html;charset=utf8");
	//開啟Session
	session_start();

    //執行登出動作

    if(!empty($_GET["id"])){
       if($_GET["id"]==0){
	      unset($_SESSION["loginMember"]);   //移除變數的值
	      unset( $_SESSION["loginAccount"]); 
       }
    }
   
	//清除Session
	session_destroy();
	//導到login.php
    echo "<script>alert('確定登出?');location.href='login.php';</script>";
?>