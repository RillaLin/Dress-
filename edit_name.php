<?php
include ("mysql.inc.php");
$errMsg='';
$name='';
session_start();
  if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
	    //未登入
      $logout = "";
      $login = "<a href='login.php'>登入</a>";
  }
  else{
    $logout = "<a href='logout.php'>登出</a>";
    $login = $_SESSION["loginAccount"];

  	if($_SESSION["loginMember"]=="c"){          //判斷不同身分會員專區的建立
  		
      $member="member.php";
  		$img="img/shoppingcart.png";
  		$imglink="shoppingcart.php";
  	}

  	}

if(!empty($_POST['name']) ){
	$name = $_POST['name'];
	$sql = "SELECT * FROM members WHERE mid = '{$_POST['name']}';";
}
else{
	$errMsg .= '您忘記輸入名稱<br>';
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>修改會員帳號</title>
	<link href="dress.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="left">
        <a href="home.php"><img src="img/logo.jpg" height="60" width="100"></a><br><br>
		<div id="list"><br>
			<ul id="u">
				<li class="point"><b>男</b><br></li>
        <ul>
          <li><a href="product_class.php?class=mtop">上身類</a></li>
          <li><a href="product_class.php?class=mlower">下身類</a></li>
        </ul>
        <li class="point"><b>女</b><br></li>
        <ul id="uu">
          <li><a href="product_class.php?class=wtop">上身類</a></li>
          <li><a href="product_class.php?class=wlower">下身類</a></li>
          <li><a href="product_class.php?class=wonepiece">連身</a></li>
        </ul>
        <li><a href="product_class.php?class=accessories">配件</a></li>
			</ul><br>
		</div>
		
	</div>

	<div id="top">
		
		<form name="sform" method="get" action="search.php">
			<a href="about.php">關於店家</a>&nbsp;&nbsp;
		    <a href="<?php echo $member; ?>">會員專區</a>&nbsp;&nbsp;
			<input type="text" name="search">
		  <input type="image" name="submit_btn" src="img/find.png" width="15" height="15" onClick="document.sform.submit();">&nbsp;&nbsp;&nbsp;&nbsp;
		  <?php echo $login;?>&nbsp;|&nbsp;
		  <a href="register.php">註冊</a>&nbsp;&nbsp;&nbsp;&nbsp;
		  <a href="<?php echo $imglink; ?>"><img src="<?php echo $img; ?>" width="20" height="20"></a>
		  	&nbsp;&nbsp;&nbsp;&nbsp;
      <?php echo $logout; ?>
		</form>
	</div>
	
	<div id="right">
		<?php
		    $mid=$_SESSION["mid"];
			if ($errMsg ==''){
				$strSQL = "UPDATE members SET mname='{$_POST['name']}' WHERE mid='{$mid}';";
				$result = mysqli_query($conn, $strSQL);

				$rowUpdated = mysqli_affected_rows($conn);

				if ($rowUpdated > 0){
					echo '已成功更新名稱<br>';
				}
				else {
					echo '無法更新名稱<br>';
				}
			}

			else {
				echo $errMsg . '請按瀏覽器的上一頁鈕重新輸入<br>';
			}
		?>
 		<p><a href="membername.php">回修改名稱頁</a></p>

	</div>
</body>
</html>