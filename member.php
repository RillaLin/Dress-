<?php
  include ("mysql.inc.php");
  $perpage = 10;
  session_start();
	
  if(empty($_SESSION["loginMember"]) && empty($_SESSION["loginAccount"]) && ($_SESSION["loginMember"]!="c")){   //登出的狀態
    echo "<script>alert('前往登入~');location.href='login.php';</script>";

  }
  else{
  	
    $logout = "<a class='more' href='logout.php'>登出</a>";
    $login = $_SESSION["loginAccount"];

  	if($_SESSION["loginMember"]=="c"){          //判斷不同身分會員專區的建立
  		
      $member="member.php";
  		$img="img/shoppingcart.png";
  		$imglink="shoppingcart.php";
  	}
 
	$memsql = "SELECT * FROM members WHERE maccount='{$_SESSION["loginAccount"]}';";
	$result2 = mysqli_query($conn,$memsql);
	while($mrow = mysqli_fetch_array($result2)){
		$_SESSION["mid"]=$mrow['mid'];
		$name=$mrow['mname'];
		$account=$mrow['maccount'];
		$sumpoint = $mrow['sumpoint'];
		break;
	}

	$sql = "SELECT checkout.oid,checkout.total,checkout.cdate,stores.sname,checkout.pname,checkout.pstyle,checkout.psize,checkout.oamount,checkout.price FROM checkout,stores WHERE checkout.mid='{$_SESSION["mid"]}' AND checkout.payfor=stores.sid ORDER BY checkout.cdate,checkout.oid ASC;";/*購物紀錄*/

	$result=mysqli_query($conn,$sql);
	
	
	$totalrow = mysqli_num_rows($result);
	$totalpage = ceil($totalrow/$perpage);
	
	

	 if(empty($_GET['page'])||!is_numeric($_GET['page']) || $_GET['page']<1 || $_GET['page']>$totalpage){
                       $page=1;
                        if($page==1){
                          $_SESSION['page']=1;  //一開始在第一頁時設的變數，之後可用以判斷上一頁
                        }
                    }
                    else{
                        $page=$_GET['page'];
                    }
  
                    $start=($page - 1) * $perpage;
                    $_SESSION['start']=$start; 
     }

    $sql2 = "SELECT checkout.oid,checkout.total,checkout.cdate,stores.sname,checkout.pname,checkout.pstyle,checkout.psize,checkout.oamount,checkout.price FROM checkout,stores WHERE checkout.mid='{$_SESSION["mid"]}' AND checkout.payfor=stores.sid ORDER BY checkout.cdate,checkout.oid ASC;";/*購物紀錄*/

	$result2=mysqli_query($conn,$sql2);

  
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>會員專區</title>
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
		
		<form name="sform" method="get" action="search.php">
			<a class="more" href="about.php">關於店家</a>&nbsp;&nbsp;
		    <a class="more" href="<?php echo $member; ?>">會員專區</a>&nbsp;&nbsp;
			<input type="text" name="search">
		  <input type="image" name="submit_btn" src="img/find.png" width="15" height="15" onClick="document.sform.submit();">&nbsp;&nbsp;&nbsp;&nbsp;
		  <?php echo $login;?>&nbsp;|&nbsp;
		  <a class="more" href="register.php">註冊</a>&nbsp;&nbsp;&nbsp;&nbsp;
		  <a href="shoppingcart.php"><img src="<?php echo $img; ?>" width="20" height="20"></a>
		  	&nbsp;&nbsp;&nbsp;&nbsp;
      <?php echo $logout; ?>
		</form>
	</div>

	<div id="right">
		<div id="r2">
			<h3 style="color:#bc8f8f;">購物紀錄</h3>
			<table  style='border:5px #db7093 solid;'  rules='all'>
				 <tr style="visibility: hidden;">
      	            <td width="80px">
                  	<td width="100px">
      				<td width="60px">
      				<td width="200px">
      				<td width="100px">
     		    </tr>
				<tr>
					<th>訂單編號&nbsp;&nbsp;&nbsp;&nbsp;</th>
					<th>購物日期&nbsp;&nbsp;&nbsp;&nbsp;</th>
					<th>店家&nbsp;&nbsp;&nbsp;&nbsp;</th>
					<th>商品資訊&nbsp;&nbsp;&nbsp;&nbsp;</th>
					<th>總計&nbsp;&nbsp;&nbsp;&nbsp;</th>
				</tr>
				<?php
				    $p=0;   //單筆訂單金額
				    $pp=0;  //總金額
                    
                   
				    while($row=mysqli_fetch_array($result2)){
				    	if(!empty( $_SESSION["cdate"])){
				    	 if($_SESSION["cdate"] != $row['cdate']){
							 echo "<tr>";
		                     echo "<td></td>";
		                     echo "<td></td>";
		                     echo "<td></td>";
		                     echo "<td></td>";
		                     echo "<td>TWD. {$p}</td>";
			                 echo "</tr>";
			                 $pp+=$p;
			                 $p=0;
				    	 }
						}

				    	$_SESSION["cdate"]=$row['cdate'];
					
					    echo "<tr>";
					    echo "<td style='font-size:13px'>{$row['oid']}</td>";
					    echo "<td style='font-size:13px'>{$row['cdate']}</td>";
					    echo "<td style='font-size:13px'>{$row['sname']}</td>";
					    echo "<td style='font-size:13px'>{$row['pname']} {$row['pstyle']} {$row['psize']}  x{$row['oamount']} TWD{$row['total']}        </td><td></td>";
					    $p+=$row['total'];
					    echo "</tr>";
					   
					}
					echo "<tr>";
		            echo "<td></td>";
		            echo "<td></td>";
		            echo "<td></td>";
		            echo "<td></td>";
		            echo "<td>TWD. {$p}</td>";
			        echo "</tr>";
	                $pp+=$p;
			                 

				    
		    echo "<tr>";
		    echo "<td style='font-size:20px;color:#db7093';>總消費金額</td>";
		    echo "<td></td>";
		    echo "<td></td>";
		    echo "<td></td>";
		    echo "<td style='font-size:20px;color:#db7093;'>TWD. {$pp}</td>";
		    echo "</tr>";
			echo "</table>";
			echo '<p>';
			for($i = 1;$i<$totalpage;$i++){
				if($i!=1) echo '&nbsp;&nbsp;&nbsp;';
				if($i==$page) echo $i;
				else 
					echo sprintf("<a class='more' href='%s?page=%d'>%d</a>", $_SERVER['PHP_SELF'], $i , $i); 
			}
			echo '</p>';
			?>
		</div>
		<div id="r2-2">
			<img src="">&nbsp;&nbsp;
			<?php
				echo "<h3>會員名稱:{$name}</h3>";
				echo '<br/>';
				echo "<h4>會員帳號:{$account}</h4>";
				echo '<br/>';
				echo "<h4>目前點數:$sumpoint</h4>";
				
			?>

			<a href="membername.php"><input id="membername" type="button" value="修改會員名稱" style="background-color: #FFE4E1;color:#BC8F8F "></a><br><br>
			<a href="memberpsd.php"><input id=" memberpsd" type="button" value="修改會員密碼" style="background-color: #FFE4E1;color:#BC8F8F "></a>
			
			


			
		</div>
	</div>

</body>
</html>