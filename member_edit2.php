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
	<title>帳號管理頁(會員)</title>
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
				<li class = "point"><a href="root_suggest.php">建議管理</a></li>
			</ul>
		</div>
	</div>
	<div id = "right">
		<h4>服飾網拍整合平台-系統後台</h4><br/>
		<h3>帳號管理(會員)</h3><br/>

		<?php
		$msql = "UPDATE members SET maccount = '{$_REQUEST['maccount']}' , mpsd = '{$_REQUEST['mpsd']}' , mname = '{$_REQUEST['mname']}' , memail = '{$_REQUEST['memail']}' , mphone = '{$_REQUEST['mphone']}' WHERE mid = {$_REQUEST['mid']}";
			$mresult = mysqli_query($conn,$msql);

			$rowUpdated = mysqli_affected_rows($conn);

			if($rowUpdated > 0){
				echo "<script>alert('成功更改會員資料~');location.href='root_mem.php';</script>";
			}else{
				echo "<script>alert('更改失敗，請重新輸入');location.href='member_edit.php';</script>";
			}
		?>
	</div>
</body>
</html>
