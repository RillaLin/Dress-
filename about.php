<?php
	include("mysql.inc.php");
	session_start();
	$img="img/shoppingcart.png";         //預設連結圖
  	$imglink="login.php";                //預設未登入
  	$member="login.php";   
	include ("mysql.inc.php");
    


	if(empty($_SESSION["loginMember"]) && empty($_SESSION["loginAccount"])){
       
    }
    else{
    	$logout = "<a class='more' href='logout.php'>登出</a>";
    	$login = $_SESSION["loginAccount"];

	if($_SESSION["loginMember"]=="c"){
		$member="member.php";
  		$img="img/shoppingcart.png";
  		$imglink="shoppingcart.php";
		$sql = "SELECT * FROM members WHERE maccount='{$_SESSION["loginAccount"]}';";
		$result = mysqli_query($conn,$sql);
		while($mrow = mysqli_fetch_array($result)){
			$_SESSION["mid"]=$mrow['mid'];
			$name=$mrow['mname'];
			$account=$mrow['maccount'];
			break;
		}
	}
	elseif($_SESSION["loginMember"]=="s"){
		$member="store.php";
  		$img="img/store.png";
  		$imglink="store.php";
		$sql = "SELECT * FROM stores WHERE saccount='{$_SESSION["loginAccount"]}';";
		$result = mysqli_query($conn,$sql);
		while($srow = mysqli_fetch_array($result)){
			$_SESSION["sid"]=$srow['sid'];
			$name=$srow['sname'];
			$account=$srow['saccount'];
			break;
		}
	}
	elseif ($_SESSION["loginMember"]=="r") {
  		$member = "root.php";
  		$img = "img/membership.png";
        $imglink = "root.php";
  	}
    }
    
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>關於店家</title>
	<link href="dress_final.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div id="left">
        <a href="home.php"><img src="img/logo.jpg" height="60" width="100"></a><br><br>
		<div id="list"><br>
			<ul id="u">
				<li class="point"><b>男</b><br></li>
        <ul>
          <li><a class="more" href="product_class.php?class=mtop">上身類</a></li>
          <li><a class="more" href="product_class.php?class=mlower">下身類</a></li>
        </ul>
        <li class="point"><b>女</b><br></li>
        <ul id="uu">
          <li><a class="more" href="product_class.php?class=wtop">上身類</a></li>
          <li><a class="more" href="product_class.php?class=wlower">下身類</a></li>
          <li><a class="more" href="product_class.php?class=wonepiece">連身</a></li>
        </ul>
        <li><a class="more" href="product_class.php?class=accessories">配件</a></li>
			</ul><br>
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
      <a href="<?php echo $imglink; ?>"><img src="<?php echo $img; ?>" width="20" height="20"></a>
        &nbsp;&nbsp;&nbsp;&nbsp;
      <?php echo $logout; ?>
		</form>
	</div>

	<div id="right">
		<div id="r1">
			
		</div>
		<div id="r1-2-member">
			<form method="get" action="allstore.php"> 
			<?php
				$_SESSION["tablename"]='stores';
				$s = "SELECT * FROM stores";
				$r = mysqli_query($conn,$s);
				$cnt = 0;

				while($row = mysqli_fetch_array($r)){
					if($row[6] == NULL){
						echo "<img src='img/store.jpg' width='150' height='150'>";
					}
					else{
						echo "<img src='http://localhost/dress/store_allimg.php?limit=$cnt,1' width='150' height='150'>";
					}
					
					echo "<a class='purple' href='allstore.php?st={$row['sid']}'><h3><b>$row[2]</b></h3></a><br/>";
					echo "<span>$row[7]</span><hr>";
					$cnt++;
				}	
				
			?>
			</form>
		</div>

	</div>

</body>
</html>