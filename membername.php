<?php
  include("mysql.inc.php");
  session_start();
  $img="img/shoppingcart.png";         //預設連結圖
  $imglink="login.php";                //預設未登入
  $member="login.php";                 //預設的會員專區
  if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
	    //未登入
      $logout = "";
      $login = "<a href='login.php'>登入</a>";
  }
  else{
    $logout = "<a href='logout.php'>登出</a>";
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
<html>
<head>
	<meta charset="UTF-8">
	<title>修改會員名稱</title>
	<link href="dress_final.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="left">
        <a href="home.php"><img src="img/logo.jpg" height="60" width="100"></a><br><br>
		<div id="list"><br>
			<ul id="u">
				<li class="point"><b>男</b><br></li>
        <ul>
          <li><a href="product_class.php?class=mtop">上身類</a></li>
          <li><a href="product_class.php?class=mlower">下身類</a></li>
        </ul>
        <li class="point"><b>女</b><br></li>
        <ul id="uu">
          <li><a href="product_class.php?class=wtop">上身類</a></li>
          <li><a href="product_class.php?class=wlower">下身類</a></li>
          <li><a href="product_class.php?class=wonepiece">連身</a></li>
        </ul>
        <li><a href="product_class.php?class=accessories">配件</a></li>

			</ul><br>
		</div>
		
	</div>

	<div id="top">
		
		<form name="sform" method="get" action="search.php">
			<a href="about.php">關於店家</a>&nbsp;&nbsp;
		    <a href="<?php echo $member; ?>">會員專區</a>&nbsp;&nbsp;
			<input type="text" name="search">
		  <input type="image" name="submit_btn" src="img/find.png" width="15" height="15" onClick="document.sform.submit();">&nbsp;&nbsp;&nbsp;&nbsp;
		  <?php echo $login;?>&nbsp;|&nbsp;
		  <a href="register.php">註冊</a>&nbsp;&nbsp;&nbsp;&nbsp;
		  <a href="<?php echo $imglink; ?>"><img src="<?php echo $img; ?>" width="20" height="20"></a>
		  	&nbsp;&nbsp;&nbsp;&nbsp;
      <?php echo $logout; ?>
		</form>
	</div>
	<div id="title2">
		<form name="editname" method="post" action="edit_name.php">
		會員名稱:<input type="text" name="name"> 
		<input id="button" type="submit" value="完成修改" style="background-color: #FFE4E1;color:#BC8F8F ">
		</form>

	</div>
		

</body>
</html>