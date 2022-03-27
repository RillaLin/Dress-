<?php
include("mysql.inc.php");
session_start();


$sql = "SELECT * FROM stores WHERE saccount = '{$_SESSION["loginAccount"]}'";
$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_array($result)){
	$_SESSION["sid"]=$row['sid'];
	$id=$row['sid'];
	$name=$row['sname'];
	break;
}


if(!empty($_POST['pname']) && !empty($_POST['pclass']) && !empty($_POST['pstyle']) && !empty($_POST['psize']) && !empty($_POST['psprice']) && !empty($_POST['poprice']) && !empty($_POST['ptxt'])){


	$size = $_POST['psize'];
	$allsize = implode (",", $size);

	// $style = $_POST['pstyle'];
	// $allstyle = implode(",", $style);
	//開啟圖片檔
	$file = fopen($_FILES["pimg"]["tmp_name"], "rb");
	//讀入圖片檔
    $fileContents = fread($file, filesize($_FILES["pimg"]["tmp_name"])); 
    //圖片檔案資料編碼
    $fileContents = base64_encode($fileContents);
    //設定日期格式
    $date = date("Y-m-d");

	$sql = "INSERT INTO product(sid,pimg,pname,pclass,pstyle,psize,psamount,pmamount,plamount,psprice,poprice,pdate,ptxt) VALUES ('$id','$fileContents','{$_POST['pname']}','{$_POST['pclass']}','{$_POST['pstyle']}','$allsize','{$_POST['psamount']}','{$_POST['pmamount']}','{$_POST['plamount']}','{$_POST['psprice']}','{$_POST['poprice']}','$date','{$_POST['ptxt']}')";
	
	$result = mysqli_query($conn,$sql);


	// $type = $_FILES["pimg"]["type"];印圖片
	// header("Content-Type: $type");
	// echo base64_decode($fileContents);
	//關閉檔案
	
		echo "<script>alert('成功新增一筆資料~');location.href='store_insert.php';</script>";

	fclose($file);
}



?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>店家管理首頁</title>
	<link href="dress_final.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id = "left">
		<a href="home.php"><img src="img/logo.jpg" height="60" width="100"></a><br><br>
		<div id="list"><br>
			<h4><?php echo $name?>
			<a class="more" id="logout_btn" href="logout.php" style="background-color: #FFE4E1;color:#BC8F8F ">登出</a></h4>
			<ul id = "u">
				<li class = "point"><a class="more" href="store.php">帳號管理</a></li>
				<li class = "point"><a class="more" href="store_pro.php">產品管理</a></li>
			</ul>
		</div>
	</div>
	<div id="right">
		<form method="post" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
			<h4>服飾網拍整合平台&nbsp;->&nbsp;店家管理</h4><br/>
			<h3>產品管理</h3><br/>
			選擇圖片:<input type="file" name="pimg" id="txt" accept=".png,.jpg" required><br/>
			產品名稱:<input name="pname" required><br/>
			類別:<select name="pclass" required>
					<option value="">請選擇
					<optgroup label="男">
						<option value="mtop">上身類
						<option value="mlower">下身類
					</optgroup>
					<optgroup label="女">
						<option value="wtop">上身類
						<option value="wlower">下身類
						<option value="wonepiece">連身
					</optgroup>
					<option value="accessories">配件
				</select><br/>
			<!-- 顏色:<input name="pstyle" required><br/> -->
			樣式:<input name="pstyle" required><br/>
			尺寸:<br/><input name="psize[]" type="checkbox" value="s">S
				 <input name="psize[]" type="checkbox" value="m">M
				 <input name="psize[]" type="checkbox" value="l">L<br/>
			S剩餘數量:<input name="psamount" required ><br/>
			M剩餘數量:<input name="pmamount" required ><br/>
			L剩餘數量:<input name="plamount" required ><br/>
			原價:<input name="psprice" required><br/>
			特價:<input name="poprice" placeholder="若沒有特價請填原價" required ><br/>
			介紹:<br/><textarea name="ptxt" required></textarea><br/>
			<input name="submit" type="submit" value="新增" style="background-color: #FFE4E1;color:#BC8F8F "><br/>
			

		</form>	
	</div>
</body>
</html>