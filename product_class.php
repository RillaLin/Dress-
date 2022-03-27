<?php
include("mysql.inc.php");
session_start();
  $img="img/shoppingcart.png";         //預設連結圖
  $imglink="login.php";                //預設未登入
  $member="login.php"; 
if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
	    //未登入
      $logout = "";
      $login = "<a class='more' href='login.php'>登入</a>";
  }
  else{
    $logout = "<a class='more' href='logout.php?id=043'>登出</a>";
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
  	elseif ($_SESSION["loginMember"]=="r") {
  		$member = "root.php";
      $img = "img/membership.png";
      $imglink = "root.php";
   }
}

$class = "{$_REQUEST['class']}";
switch ($class){
  case 'mtop':
    $class = '男上身類';
    break;
  case 'mlower':
    $class = '男下身類';
    break;
  case 'wtop':
    $class = '女上身類';
    break;
  case 'wlower':
    $class = '女下身類';
    break;
  case 'wonepiece':
    $class = '女連身類';
    break;
  case 'accessories':
    $class = '配件類';
    break;    
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $class ?></title>
	<link href="dress_final.css" rel="stylesheet" type="text/css">
</head>
<body>
	 <div id="left">
        <a href="home.php"><img src="img/logo.jpg" height="60" width="100"></a><br><br>
		<div id="list"><br>
			<ul id="u">
				<li class="point"><b>男</b><br></li>
				<ul id="uu">
					<li><a class="more" id="aa" href="product_class.php?class=mtop">上身類</a></li>
					<li><a class="more" id="aa" href="product_class.php?class=mlower">下身類</a></li>
				</ul>
				<li class="point"><b>女</b><br></li>
				<ul id="uu">
					<li><a class="more" id="aa" href="product_class.php?class=wtop">上身類</a></li>
					<li><a class="more" id="aa" href="product_class.php?class=wlower">下身類</a></li>
					<li><a class="more" id="aa" href="product_class.php?class=wonepiece">連身</a></li><br>
				</ul>
				<li><a class="more" id="aa" href="product_class.php?class=accessories">配件</a></li>
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
		  <a href="<?php echo $imglink; ?>"><img src="<?php echo $img; ?>" width="20" height="20"></a>
		  	&nbsp;&nbsp;&nbsp;&nbsp;
      <?php echo $logout; ?>
		</form>
	</div>

	<div id="right">
		<?php

		if(empty($_GET["class"])){
			 
		}
		else{
      $_SESSION["class"]=$_GET["class"];
		}

    if(!empty($_SESSION["class"])) {
      $sql="SELECT * FROM product WHERE pclass= '{$_SESSION['class']}'";
    }   
	   

     $result = mysqli_query($conn,$sql);
     $perpage=18;

     $numRows=mysqli_num_rows($result);  //搜尋商品總筆數
    

     $totalpage=ceil($numRows/$perpage);
     
     $_SESSION["img_id"]='product_class';

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


      $sql2="SELECT * FROM product WHERE pclass= '{$_SESSION['class']}' LIMIT {$_SESSION['start']},6";
      $result2=mysqli_query($conn,$sql2);
      $result3=mysqli_query($conn,$sql2);
   
  
        if(!empty($_GET['cnt'])){   //顯示圖片的分頁
                   $_SESSION["cnt"]=(6*($_GET['page']-1));
                }
                else{
                   $_SESSION["cnt"]=0;
                }   


    echo"<table>";
        //第一行
        echo "<tr>";
        while($row=mysqli_fetch_array($result2)){
        	$name='';
        	$stsql="SELECT stores.sname FROM stores WHERE stores.sid={$row['sid']} ";
        	$stresult=mysqli_query($conn,$stsql);
        	while($row2=mysqli_fetch_array($stresult)){
        		$name=$row2['sname'];
        	}
             echo "<td><a href='batvest.php?pr={$row['pid']}&st={$row['sid']}'><img src='http://localhost/dress/test.php?limit={$_SESSION["cnt"]},1' width='150' height='180'></a></td>";

        $_SESSION["cnt"]++;
       }
           echo "</tr>";
           echo "<tr>";

        while($row=mysqli_fetch_array($result3)){
          $name='';
          $stsql="SELECT stores.sname FROM stores WHERE stores.sid={$row['sid']} ";
          $stresult=mysqli_query($conn,$stsql);
          while($row2=mysqli_fetch_array($stresult)){
            $name=$row2['sname'];
          }
             echo "<td>$row[2]<br>$name&nbsp;NT.$row[12]<br></td>";
       }
          $_SESSION['start']=$_SESSION['start']+6;
          echo "</tr>";

          //第二行
        echo "<tr>";
        $sql4="SELECT * FROM product WHERE pclass= '{$_SESSION['class']}' LIMIT {$_SESSION['start']},6";
        $result4=mysqli_query($conn,$sql4);
        while($row=mysqli_fetch_array($result4)){
          $name='';
          $stsql="SELECT stores.sname FROM stores WHERE stores.sid={$row['sid']} ";
          $stresult=mysqli_query($conn,$stsql);
          while($row2=mysqli_fetch_array($stresult)){
            $name=$row2['sname'];
          }
             echo "<td><a href='batvest.php?pr={$row['pid']}&st={$row['sid']}'><img src='http://localhost/dress/test.php?limit={$_SESSION["cnt"]},1' width='150' height='180'></a></td>";

        $_SESSION["cnt"]++;
       }

        echo "</tr>";
        echo "<tr>";
        $sql5="SELECT * FROM product WHERE pclass= '{$_SESSION['class']}' LIMIT {$_SESSION['start']},6";
        $result5=mysqli_query($conn,$sql5);
        while($row=mysqli_fetch_array($result5)){
          $name='';
          $stsql="SELECT stores.sname FROM stores WHERE stores.sid={$row['sid']} ";
          $stresult=mysqli_query($conn,$stsql);
          while($row2=mysqli_fetch_array($stresult)){
            $name=$row2['sname'];
          }
             echo "<td>$row[2]<br>$name&nbsp;NT.$row[12]<br></td>";
       }
           $_SESSION['start']=$_SESSION['start']+6;
          echo "</tr>";

          //第三行
        echo "<tr>";
        $sql6="SELECT * FROM product WHERE pclass= '{$_SESSION['class']}' LIMIT {$_SESSION['start']},6";
        $result6=mysqli_query($conn,$sql6);
        while($row=mysqli_fetch_array($result6)){
          $name='';
          $stsql="SELECT stores.sname FROM stores WHERE stores.sid={$row['sid']} ";
          $stresult=mysqli_query($conn,$stsql);
          while($row2=mysqli_fetch_array($stresult)){
            $name=$row2['sname'];
          }
             echo "<td><a href='batvest.php?pr={$row['pid']}&st={$row['sid']}'><img src='http://localhost/dress/test.php?limit={$_SESSION["cnt"]},1' width='150' height='180'></a></td>";

        $_SESSION["cnt"]++;
       }
           echo "</tr>";
           echo "<tr>";
        $sql7="SELECT * FROM product WHERE pclass= '{$_SESSION['class']}' LIMIT {$_SESSION['start']},6";
        $result7=mysqli_query($conn,$sql7);
        while($row=mysqli_fetch_array($result7)){
          $name='';
          $stsql="SELECT stores.sname FROM stores WHERE stores.sid={$row['sid']} ";
          $stresult=mysqli_query($conn,$stsql);
          while($row2=mysqli_fetch_array($stresult)){
            $name=$row2['sname'];
          }
             echo "<td>$row[2]<br>$name&nbsp;NT.$row[12]<br></td>";
       }
          echo "</tr>";


      echo "</table><br><br>";

      //直接跳頁
         for($i=1;$i<=$totalpage;$i++){
              if($i != 1) echo "&nbsp;";
              if($i == $page) echo "$i";
         else{
              echo sprintf("<a href='%s?page=%d&cnt=%d'>%d</a>",$_SERVER['PHP_SELF'],$i,$_SESSION["cnt"],$i);
         }
    }

		?>
	</div>
	

</body>
</html>