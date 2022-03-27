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
    $logout = "<a href='logout.php?id=043'>登出</a>";
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

  $perpage=12;
  $sql="SELECT * FROM product;";
  $result=mysqli_query($conn,$sql);
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


  $sql2="SELECT * FROM product ORDER BY samount DESC LIMIT {$_SESSION['start']},6;";   //照銷售數量高到低排
  $result2=mysqli_query($conn,$sql2);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Dress-熱銷商品</title>
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

  <div class="sa">
  	
    <table>
  	  <tr>      <!--熱銷產品(全部商品)-->  
        <td>
          熱銷商品
        </td>

      </tr>
      <tr>
        <?php
          if(!empty($_GET['cnt'])){   //顯示圖片的分頁
                   $_SESSION["cnt"]=(12*($_GET['page']-1));
          }
          else{
             $_SESSION["cnt"]=0;
          }   

          while($row2 = mysqli_fetch_array($result2)){
              $_SESSION["tablename"]='product';
              $_SESSION["img_id"]='hot';
              echo  "<td><a href='batvest.php?pr={$row2['pid']}&st={$row2['sid']}'><img src='http://localhost/dress/test.php?limit={$_SESSION["cnt"]},1' width='150' height='180'></a></td>";   //典籍圖片需跳至自己的商品頁
              $_SESSION["cnt"]++;
          }
          $_SESSION['start']=$_SESSION['start']+6;
        ?>
  	  </tr>
      <tr>
        <?php
          $sql3="SELECT * FROM product ORDER BY samount DESC LIMIT {$_SESSION['start']},6;";   //照銷售數量高到低排
          $result3=mysqli_query($conn,$sql3);
          while($row3 = mysqli_fetch_array($result3)){
              $_SESSION["tablename"]='product';
              $_SESSION["img_id"]='home2';
              echo  "<td><a href='batvest.php?pr={$row3['pid']}&st={$row3['sid']}'><img src='http://localhost/dress/test.php?limit={$_SESSION["cnt"]},1' width='150' height='180'></a></td>";        //典籍圖片需跳至自己的商品頁
              $_SESSION["cnt"]++;
          }
          $_SESSION["cnt"]=$_SESSION["cnt"]-1;  //多加的減回來
         
        ?>
      </tr>
    </table>

    <?php
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