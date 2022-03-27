<?php
	include("mysql.inc.php");
	session_start();

	$sql = "SELECT * FROM stores WHERE saccount = '{$_SESSION["loginAccount"]}'";
	$result = mysqli_query($conn,$sql);

	while($srow = mysqli_fetch_array($result)){
		$_SESSION["sid"]=$srow['sid'];
		$sid=$_SESSION["sid"];
		$name=$srow['sname'];
		$txt=$srow['stxt'];
		$phone=$srow['sphone'];
		break;
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>店家管理首頁</title>
	<link href="dress_store.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id = "left">
		<a href="home.php"><img src="img/logo.jpg" height="60" width="100"></a><br><br>
		<div id="list"><br/>
			<h4><?php echo $name?>
			<a id="logout_btn" href="logout.php" style="background-color: #FFE4E1;color:#BC8F8F ">登出</a>
			<ul id = "u"></h4>
				<li class = "point"><a href="store.php">帳號管理</a></li>
				<li class = "point"><a href="store_pro.php">產品管理</a></li>
			</ul>
		</div>
	</div>
	<div id="right">
		<form method="post" action="store_up.php" enctype="multipart/form-data">
		<h4>服飾網拍整合平台&nbsp;->&nbsp;店家管理</h4><br/>
		<h3>帳號管理</h3><br/>

		更改商家圖片:<input type="file" name="simg" accept=".png,.jpg" required><br/><br/>
		店家名稱:<input name="sname" value="<?php echo "$name" ?>" required><br/><br/>
		介紹:<br/><textarea name="stxt" value="<?php echo "$txt" ?>" required></textarea><br/><br/>
		聯絡方式:<input name="sphone" value="<?php echo "$phone"?>" required><br/><br/>

		<input name="submit" type="submit" value="更改" style="background-color: #FFE4E1;color:#BC8F8F "><br/>

		</form>

	</div>
</body>
</html>
