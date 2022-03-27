<?php
	include("mysql.inc.php");
	session_start();

	$sql = "SELECT * FROM stores WHERE saccount = '{$_SESSION["loginAccount"]}'";
	$result = mysqli_query($conn,$sql);

	while($srow = mysqli_fetch_array($result)){
		$_SESSION["sid"]=$srow['sid'];
		$sid=$_SESSION["sid"];
		$name=$srow['sname'];
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
			<a id="logout_btn" href="logout.php" style="background-color: #FFE4E1;color:#BC8F8F ">登出</a></h4>
			<ul id = "u">
				<li class = "point"><a href="store.php">帳號管理</a></li>
				<li class = "point"><a href="store_pro.php">產品管理</a></li>
			</ul>
		</div>
	</div>
	<div id="right">
		<form method="post" action="store_up.php">
		<h4>服飾網拍整合平台&nbsp;->&nbsp;店家管理</h4><br/>
		<h3>帳號管理</h3><br/>
		</form>
	<?php
		
	//開啟圖片檔
	$file = fopen($_FILES["simg"]["tmp_name"], "rb");
	//讀入圖片檔
    $fileContents = fread($file, filesize($_FILES["simg"]["tmp_name"])); 
    //圖片檔案資料編碼
    $fileContents = base64_encode($fileContents);
	$sql = "UPDATE stores SET simg='$fileContents' , sname='{$_POST['sname']}' , stxt='{$_POST['stxt']}' , sphone='{$_POST['sphone']}' WHERE sid='{$sid}';";
	$result = mysqli_query($conn, $sql);

	$rowUpdated = mysqli_affected_rows($conn);

	if ($rowUpdated > 0){
		echo "<script>alert('成功更改簡介~');location.href='store.php';</script>";
	}
	else {
		echo "<script>alert('更改失敗，請重新輸入');location.href='edit_store.php';</script>";
	}
	fclose($file);
	?>
	<p><a href="store.php">回帳號頁</a></p>
	</div>
</body>
</html>
