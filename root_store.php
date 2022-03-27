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

     if(!empty($_POST["srh"])){//關鍵字
       $sql="SELECT * FROM stores WHERE sid={$_POST["srh"]}  ORDER BY sid";
    }
    else{
       $sql = "SELECT * FROM stores ORDER BY sid ASC";
    }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>帳號管理頁(店家)</title>
	<link href="dress_root_fianl.css" rel="stylesheet" type="text/css">
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
					<li class='point'><a class="more" href="root_mem.php">會員</a></li>
					<li class='point'>店家</li>
				</ul>
				<li class = "point"><a class="more" href="root_pro.php">產品管理</a></li>
				<li class = "point"><a class="more" href="root_sales.php">銷售管理</a></li>
				<li class = "point"><a class="more" href="root_suggest.php">建議管理</a></li>
			</ul>
		</div>
	</div>
	<div id = "right">
		<br><br><br><br><br><br><br>
		<h4>服飾網拍整合平台-系統後台</h4><br>
		<h3>帳號管理(店家)</h3><br/>

        <form name="sform" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
		查詢店家id:<input type="text" name="srh"> &nbsp;&nbsp;
		<input name="submit" type="submit" value="查詢" style="background-color: #FFE4E1;color:#BC8F8F "><br/><br/>
	    </form>

		<table border ='1'>
			<tr>
				<th>帳號</th>
				<th>密碼</th>
				<th>店家id</th>
				<th>店家名稱</th>
				<th>Email</th>
				<th>電話號碼</th>
			</tr>
			<?php
                 $perpage=10;

                 $result = mysqli_query($conn,$sql);
                
                $numRows=mysqli_num_rows($result);  //搜尋商品總筆數
    
                $totalpage=ceil($numRows/$perpage);

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

                
				$sql2 = $sql." LIMIT {$_SESSION['start']},10";
				$result2 = mysqli_query($conn,$sql2);

				
				while($row = mysqli_fetch_array($result2)){
					echo "<tr>
						  <td>$row[1]</td>
						  <td>$row[3]</td>
						  <td>$row[0]</td>
						  <td>$row[2]</td>
						  <td>$row[4]</td>
						  <td>$row[5]</td>
						  <td><a href='store_del.php?del={$row['sid']}'>刪除</a></td>
						  <td><a href='store_edit.php?del={$row['sid']}'>編輯</a></td>
						  </tr>";
				}			
			?>	
		</table><br>

		<?php
         //直接跳頁
         for($i=1;$i<=$totalpage;$i++){
              if($i != 1) echo "&nbsp;";
              if($i == $page) echo "$i";
              else{
                echo sprintf("<a class='more' href='%s?page=%d&cnt=%d'>%d</a>",$_SERVER['PHP_SELF'],$i,$_SESSION["cnt"],$i);
              }
         }
    
         ?>

	</div>
</body>
</html>