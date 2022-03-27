<?php
	include("mysql.inc.php");

	session_start();
	// $_SESSION['img'] = 'pimg';
	

	$sql = "SELECT * FROM stores WHERE saccount = '{$_SESSION["loginAccount"]}'";
	$result = mysqli_query($conn,$sql);


	while($srow = mysqli_fetch_array($result)){
		$_SESSION["sid"]=$srow['sid'];
		$id=$srow['sid'];
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
		<div id="list"><br>
			<h4><?php echo $name;?>
			<a id="logout_btn" href="logout.php" style="background-color: #FFE4E1;color:#BC8F8F ">登出</a></h4>
			<ul id = "u">
				<li class = "point"><a href="store.php">帳號管理</a></li>
				<li class = "point">產品管理</li>
			</ul>
		</div>
	</div>
	<div id="right">
		<h4>服飾網拍整合平台&nbsp;->&nbsp;產品管理</h4><br/>
		<h3>產品管理</h3><br/>
		<?php

			if(!empty($_POST['pname']) && !empty($_POST['pclass']) && !empty($_POST['pstyle']) && !empty($_POST['psize']) && !empty($_POST['psprice']) && !empty($_POST['poprice']) && !empty($_POST['ptxt'])){
				$size = $_POST['psize'];
				$allsize = implode (",", $size);

			$sql = "UPDATE product SET pname = '{$_POST['pname']}' , pclass = '{$_POST['pclass']}' , pstyle = '{$_POST['pstyle']}' , psize = '$allsize' , psamount = '{$_POST['psamount']}' , pmamount = '{$_POST['pmamount']}' , plamount = '{$_POST['plamount']}' , psprice = '{$_POST['psprice']}' , poprice = '{$_POST['poprice']}' , ptxt = '{$_POST['ptxt']}' WHERE pid = '{$_POST['pid']}' AND sid = '$id';";
			
			mysqli_query($conn,$sql);

			$rowDeleted = mysqli_affected_rows($conn);

			if($rowDeleted > 0){
				echo "編輯成功~";
			}
			else{
				echo "編輯失敗";
			}
		}
		?>
		<p><a href="store_pro.php">回商品管理頁</a></p>
	</div>
</body>
</html>