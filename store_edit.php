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
	<title>帳號管理頁(店家)</title>
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
		<h3>帳號管理(店家)</h3><br/>

		<?php
			$sql = "SELECT * FROM stores WHERE sid = {$_REQUEST['del']}";
			$result = mysqli_query($conn,$sql);
			while($row = mysqli_fetch_array($result)){
				$saccount = $row[1];
				$spsd = $row[3];
				$sname = $row[2];
				$semail = $row[4];
				$sphone = $row[5];
				$sid = $row[0];
			}
		?>
		<form method="post" action="store_edit2.php">
		<input type="hidden" name="sid" value="<?php echo $sid; ?>">
        帳號<input type="text" name="saccount" value="<?php echo $saccount; ?>" required><br/><br/>
		密碼<input name="spsd" value="<?php echo $spsd; ?>" required><br/><br/>
		會員名稱<input name="sname" value="<?php echo $sname; ?>" required><br/><br/>
		Email<input name="semail" value="<?php echo $semail; ?>" required><br/><br/>
		電話號碼<input name="sphone" value="<?php echo $sphone; ?>" required><br/><br/>

		<input name="submit" type="submit" value="更改" style="background-color: #FFE4E1;color:#BC8F8F "><br/>
		</form>


	</div>
</body>
</html>