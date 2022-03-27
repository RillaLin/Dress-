<?php
	include("mysql.inc.php");
	session_start();
	$_SESSION['tablename'] = 'product';
	// $_SESSION['img'] = 'pimg';
	

	$sql = "SELECT * FROM stores WHERE saccount = '{$_SESSION["loginAccount"]}'";
	$result = mysqli_query($conn,$sql);


	while($srow = mysqli_fetch_array($result)){
		$_SESSION["sid"]=$srow['sid'];
		$id=$srow['sid'];
		$name=$srow['sname'];
		$txt=$srow['stxt'];
		$phone=$srow['sphone'];
		break;
	}


  $perpage=10; 
  $totalrow=mysqli_num_rows($result);
  $totalpage=ceil($totalrow/$perpage);

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

   if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
        //未登入
   		$logout = "";
      $login = "<a class='more' href='login.php'>登入</a>";
  }
  else{
  	$logout = "<a class='more' href='logout.php'>登出</a>";
    $login = $_SESSION["loginAccount"];
    
    if ($_SESSION["loginMember"]=="s") {
        $member="store.php";
        $img="img/store.png";
        $imglink="store.php";
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
		<div id="list"><br>
			<h4><?php echo $name?>
			<a id="logout_btn" href="logout.php" style="background-color: #FFE4E1;color:#BC8F8F ">登出</a></h4>
			<ul id = "u">
				<li class = "point"><a class="more" href="store.php">帳號管理</a></li>
				<li class = "point">產品管理</li>
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

	<div id="right">
		<h4>服飾網拍整合平台&nbsp;->&nbsp;產品管理</h4><br/>
		<h3>產品管理</h3><br/>
		<form method="get" action="product_edit.php">
			<input type="submit" name="register" value="新增商品" onClick="this.form.action='store_insert.php';"><br>
		
		
	<?php
		$sql = "SELECT * FROM product WHERE sid ='{$_SESSION["sid"]}' ORDER BY pid";

		$result = mysqli_query($conn,$sql);
        
		$rrow = mysqli_num_rows($result);//反回一個數值

        $perpage=5;
        $totalpage=ceil($rrow/$perpage);


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
   

        $sql2 = "SELECT * FROM product WHERE sid ='{$_SESSION["sid"]}' ORDER BY pid LIMIT {$_SESSION['start']},5";
        $result2=mysqli_query($conn,$sql2);

		$_SESSION["img_id"]='store';
		$_SESSION["tablename"]='product';
		$cnt = 0;
		if($rrow > 0){
			echo "<br><table style='border:5px #add8e6 solid;'  rules='all'>
				  <tr><th>圖片</th>
				  	  <th>產品編號</th>
				  	  <th>產品名稱</th>
				  	  <th>類別</th>
				  	  <th>樣式</th>
				  	  <th>尺寸</th>
				  	  <th>S剩餘數量</th>
				  	  <th>M剩餘數量</th>
				  	  <th>L剩餘數量</th>
				  	  <th>原價</th>
				  	  <th>特價</th>
				  	  <th>上架日期</th>
				  	  <th></th><th></th>
				  	  </tr>";


                if(!empty($_GET['cnt'])){   //顯示圖片的分頁
                   $_SESSION["cnt"]=(5*($_GET['page']-1));
                }
                else{
                   $_SESSION["cnt"]=0;
                }   	  	  

			while($row = mysqli_fetch_array($result2)){
				//limit x,y 從第x筆取y筆資料
				echo "<tr><td><img src='http://localhost/dress/test.php?limit={$_SESSION["cnt"]},1' width='200'></td>
					  	  <td style='font-size:13px' >{$row['pid']}</td>
					  	  <td style='font-size:13px'>{$row['pname']}</td>
					  	  <td style='font-size:13px'>{$row['pclass']}</td>
					  	  <td style='font-size:13px'>{$row['pstyle']}</td>
					  	  <td style='font-size:13px'>{$row['psize']}</td>
					  	  <td style='font-size:13px'>{$row['psamount']}</td>
					  	  <td style='font-size:13px'>{$row['pmamount']}</td>
					  	  <td style='font-size:13px'>{$row['plamount']}</td>
					  	  <td style='font-size:13px'>{$row['psprice']}</td>
					  	  <td style='font-size:13px'>{$row['poprice']}</td>
					  	  <td style='font-size:13px'>{$row['pdate']}</td>
					  	  <td style='font-size:13px'><a href='product_del.php?del={$row['pid']}'>刪除</a></td>
					  	  <td style='font-size:13px'><a href='product_edit.php?edit={$row['pid']}'>編輯</a></td>
					  	  </tr>";
					  	  $_SESSION["cnt"]++;
			}
			echo '</table><br>';
		}

		//直接跳頁
         for($i=1;$i<=$totalpage;$i++){
              if($i != 1) echo "&nbsp;";
              if($i == $page) echo "$i";
            else{
              echo sprintf("<a class='more' href='%s?page=%d&cnt=%d'>%d</a>",$_SERVER['PHP_SELF'],$i,$_SESSION["cnt"],$i);
            }
         }

	?>
	</form>
	</div>
</body>
</html>