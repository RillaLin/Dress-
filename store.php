<?php
	include("mysql.inc.php");
	session_start();
	$_SESSION['tablename'] = 'stores';
	// $_SESSION['img'] = 'simg';
	// $_SESSION['id'] = 'sid';

	$sql = "SELECT * FROM stores WHERE saccount = '{$_SESSION["loginAccount"]}'";
	$result = mysqli_query($conn,$sql);

	while($srow = mysqli_fetch_array($result)){
		$_SESSION["sid"]=$srow['sid'];
		$sid=$srow['sid'];
		$name=$srow['sname'];
		$txt=$srow['stxt'];
		$phone=$srow['sphone'];
		break;
	}

  $img="img/shoppingcart.png";         //預設連結圖
  $imglink="login.php";                //預設未登入
  $member="login.php";                 //預設的會員專區
  if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
        //未登入
      $logout = "";
      $login = "<a class='more' href='login.php'>登入</a>";
  }
  else{
    $logout = "<a class='more' href='logout.php'>登出</a>";
    $login = $_SESSION["loginAccount"];

    if($_SESSION["loginMember"]=="c"){          //判斷不同身分會員專區的建立
        
      $member="member.php";
        $img="img/shoppingcart.png";
        $imglink="shoppingcart.php";
    }
    elseif ($_SESSION["loginMember"]=="s") {
        $member="store.php";
        $img="img/store.png";
        $imglink="store.php";
    }
    elseif ($_SESSION["loginMember"]=="m") {
        $member = "root.php";

    }
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
		<div id="list"><br/>
			<h4><?php echo $name?>
			<a class="more" id="logout_btn" href="logout.php" style="background-color: #FFE4E1;color:#BC8F8F ">登出</a></h4>
			<ul id = "u">
				<li class = "point">帳號管理</li>
				<li class = "point"><a class="more" href="store_pro.php">產品管理</a></li>
			</ul>
		</div>
	</div>
	<div id="top">
		
		<form name="sform" method="post" action="search.php">
			<a class="more" href="about.php">關於店家</a>&nbsp;&nbsp;
            <a class="more" href="<?php echo $member; ?>">會員專區</a>&nbsp;&nbsp;
            <input type="text" name="search">
          <input type="image" name="submit_btn" src="img/find.png" width="15" height="15" onClick="document.sform.submit();">&nbsp;&nbsp;&nbsp;&nbsp;
          <?php echo $login;?>&nbsp;|&nbsp;
          <a class="more" href="register.php">註冊</a>&nbsp;&nbsp;&nbsp;&nbsp;
          <a class="more" href="<?php echo $imglink; ?>"><img src="<?php echo $img; ?>" width="20" height="20"></a>
            &nbsp;&nbsp;&nbsp;&nbsp;
      <?php echo $logout; ?>
		</form>
	</div>
	<div id="right-shop">
		<form method="post" action="store_img.php">
		<h4>服飾網拍整合平台&nbsp;->&nbsp;店家管理</h4><br/>
		<h3>帳號管理</h3><br/>
		<form id="store" method="post" action="store_img.php">
			<img id='left' src='http://localhost/dress/store_img.php?' width='200'>
			
			<h4><?php echo $name?></h4><br/>
			<h4><?php echo $txt?></h4><br/>
			<h4><?php echo $phone?></h4><br/>
			<input type="hidden" name="sid" value="<?php echo '$sid'; ?>">

		<a href="edit_store.php"><input id="edit" type="button" value="修改資料" style="background-color: #FFE4E1;color:#BC8F8F "></a><br/>
		</form>

		
	</div>
</body>
</html>