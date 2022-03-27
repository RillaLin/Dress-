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
			$sql = "SELECT * FROM members WHERE mid = {$_REQUEST['del']}";
			$result = mysqli_query($conn,$sql);
			while($row = mysqli_fetch_array($result)){
				$maccount = $row[1];
				$mpsd = $row[3];
				$mname = $row[2];
				$memail = $row[4];
				$mphone = $row[5];
				$mid = $row[0];
			}
		?>
		<form method="post" action="member_edit2.php">
		<input type="hidden" name="mid" value="<?php echo $mid; ?>">
        帳號<input type="text" name="maccount" value="<?php echo $maccount; ?>" required><br/><br/>
		密碼<input name="mpsd" value="<?php echo $mpsd; ?>" required><br/><br/>
		會員名稱<input name="mname" value="<?php echo $mname; ?>" required><br/><br/>
		Email<input name="memail" value="<?php echo $memail; ?>" required><br/><br/>
		電話號碼<input name="mphone" value="<?php echo $mphone; ?>" required><br/><br/>

		<input name="submit" type="submit" value="更改" style="background-color: #FFE4E1;color:#BC8F8F "><br/>
		</form>


	</div>
</body>
</html>