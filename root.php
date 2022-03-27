<?php
	include("mysql.inc.php");
	session_start();
	$_SESSION['tablename'] = 'root';
	// $_SESSION['img'] = 'simg';
	// $_SESSION['id'] = 'sid';

	$sql = "SELECT * FROM root WHERE raccount = '{$_SESSION["loginAccount"]}'";
	$result = mysqli_query($conn,$sql);

	while($row = mysqli_fetch_array($result)){
		$_SESSION["rid"]=$row['rid'];
		$rid=$row['rid'];
		break;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>管理者管理首頁</title>
	<link href="dress_root_fianl.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id = "left">
		<a href="home.php"><img src="img/logo.jpg" height="60" width="100"></a><br><br>
		<div id="list"><br/>
			<h4>管理者
			<a id="logout_btn" href="logout.php" style="background-color: #FFE4E1;color:#BC8F8F ">登出</a></h4>
			<ul id = "u">
				<li class = "point">帳號管理</li>
				<ul>
					<li class='point'><a class="more" href="root_mem.php">會員</a></li>
					<li class='point'><a class="more" href="root_store.php">店家</a></li>
				</ul>
				<li class = "point"><a class="more" href="root_pro.php">產品管理</a></li>
				<li class = "point"><a class="more" href="root_sales.php">銷售管理</a></li>
				<li class = "point"><a class="more" href="root_suggest.php">建議管理</a></li>
			</ul>
		</div>
	</div>
</body>
</html>