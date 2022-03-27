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
	<link href="dress_store.css" rel="stylesheet" type="text/css">
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
					<li class='point'><a href="root_mem.php">會員</a></li>
					<li class='point'><a href="root_store.php">店家</a></li>
				</ul>
				<li class = "point"><a href="root_pro.php">產品管理</a></li>
				<li class = "point"><a href="root_sales.php">銷售管理</a></li>
			</ul>
		</div>
	</div>
	<div id = "right">
		<h4>服飾網拍整合平台-系統後台</h4><br/>
		<h3>帳號管理(會員)</h3><br/>

		<?php
			if(!empty($_REQUEST['del'])){
			$sql = "DELETE FROM stores WHERE sid = '{$_REQUEST['del']}'";
			mysqli_query($conn,$sql);

			$rowDeleted = mysqli_affected_rows($conn);

			if($rowDeleted > 0){
				echo "刪除成功~";
			}
			else{
				echo "刪除失敗";
			}
		}
		?>
		<p><a href="root_store.php">回管理會員頁</a></p>
	</div>
</body>
</html>