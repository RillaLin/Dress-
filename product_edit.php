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
			<h4><?php echo $name?>
			<a id="logout_btn" href="logout.php" style="background-color: #FFE4E1;color:#BC8F8F ">登出</a></h4>
			<ul id = "u">
				<li class = "point"><a href="store.php">帳號管理</a></li>
				<li class = "point"><a href="store_pro.php">產品管理</a></li>
			</ul>
		</div>
	</div>
	<div id="right">
		<form method="post" action="product_edit2.php" enctype="multipart/form-data">
			<h4>服飾網拍整合平台&nbsp;->&nbsp;店家管理</h4><br/>
			<h3>產品管理</h3><br/>
			<?php
			if(!empty($_REQUEST['edit'])){
				$prosql = "SELECT * FROM product WHERE sid = '$id' AND pid = '{$_REQUEST['edit']}';";
				
				$presult = mysqli_query($conn,$prosql);

				$prow = mysqli_fetch_array($presult);
			}
			else{
				header("Location:store_pro.php");
			}
				
			?>
			選擇圖片:<input type="file" name="pimg" id="txt" accept=".png,.jpg" required><br/>
			產品名稱:<input name="pname" value="<?php echo $prow[2]; ?>" required><br/>
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
			樣式:<input name="pstyle" value="<?php echo $prow[5]; ?>" required><br/>
			尺寸:<br/><input name="psize[]" type="checkbox" value="s">S
				 <input name="psize[]" type="checkbox" value="m">M
				 <input name="psize[]" type="checkbox" value="l">L
				 <input name="psize[]" type="checkbox" value="xl">XL<br/>
			S剩餘數量:<input name="psamount" value="<?php echo $prow[7]; ?>" required ><br/>
			M剩餘數量:<input name="pmamount" value="<?php echo $prow[8]; ?>" required ><br/>
			L剩餘數量:<input name="plamount" value="<?php echo $prow[9]; ?>" required ><br/>
			原價:<input name="psprice" value="<?php echo $prow[11]; ?>" required><br/>
			特價:<input name="poprice" placeholder="若沒有特價請填原價" value="<?php echo $prow[12]; ?>" required ><br/>
			介紹:<br/><input name="ptxt" value="<?php echo $prow[14]; ?>" required ><br/>
			<input type="hidden" name="pid" value="<?php echo $prow[1]; ?>">
			<input name="submit" type="submit" value="編輯" style="background-color: #FFE4E1;color:#BC8F8F "><br/>
			

		</form>	
	</div>
</body>
</html>