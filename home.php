<?php
  include("mysql.inc.php");
  session_start();
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

  $sql2="SELECT * FROM product ORDER BY samount DESC LIMIT 6;";   //照銷售數量高到低排
  $result2=mysqli_query($conn,$sql2);

  $sql1="SELECT * FROM product ORDER BY pdate DESC LIMIT 6;";   //照上架日期排序(新到舊)
  $result1=mysqli_query($conn,$sql1);

  $sql3="SELECT * FROM product WHERE psprice > poprice ORDER BY poprice LIMIT 6;";   //特價商品照價錢低到高排
  $result3=mysqli_query($conn,$sql3);



?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Dress-服飾網站店家整合平台</title>
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

  <div id="show">
  	<table>
      <tr> 
        <!--當季新品(全部商品)-->  
        <td id="new">
          <h2>當季新品</h2>
        </td>
      </tr>
      
  	  <tr>         
           <?php
             $cnt1 = 0;
             while($row1 = mysqli_fetch_array($result1)){
                 $_SESSION["tablename"]='product';
                 $_SESSION["img_id1"]='home1';
                 echo  "<td><a href='batvest.php?pr={$row1['pid']}&st={$row1['sid']}'><img src='http://localhost/dress/test2.php?limit1={$cnt1},1' width='150' height='180'></a></td>";   //典籍圖片需跳至自己的商品頁
                 $cnt1++;
             }
           ?>
           <td ><a class="more" href="p_date.php">more...</a></td>   
  	  </tr>	
      <tr>    
          <td align='center'><img src="img/1.png" width="35" height="35"></a> </td>
          <td align='center'><img src="img/2.png" width="35" height="35"></a> </td>
          <td align='center'><img src="img/3.png" width="35" height="35"></a> </td>
      </tr>

    </table>
  </div><br>
  <div id="show">
    <table>
  	  <tr>      <!--熱銷產品(全部商品)-->  
        <td id="new">
          <h2>熱銷商品</h2>
        </td>
      </tr>
      <tr>
        
           <?php
             $cnt2 = 0;
             while($row2 = mysqli_fetch_array($result2)){
                 $_SESSION["tablename"]='product';
                 $_SESSION["img_id"]='home2';
                 echo  "<td><a href='batvest.php?pr={$row2['pid']}&st={$row2['sid']}'><img src='http://localhost/dress/test.php?limit={$cnt2},1' width='150' height='180'></a></td>";   //典籍圖片需跳至自己的商品頁
                 $cnt2++;
             }
           ?>
         
         <td><a class="more" href="s_hot.php">more...</a></td>
  	  </tr>
       <tr>    
          <td align='center'><img src="img/1.png" width="35" height="35"></a> </td>
          <td align='center'><img src="img/2.png" width="35" height="35"></a> </td>
          <td align='center'><img src="img/3.png" width="35" height="35"></a> </td>
      </tr>
    </table>
  </div><br>
  <div id="show">
    <table>
      <tr>      <!--促銷商品-->
        <td id="new">
          <h2>促銷商品</h2>
        </td>
      </tr>
      <tr>     
        
           <?php
             $cnt3 = 0;
             while($row3 = mysqli_fetch_array($result3)){
                 $_SESSION["tablename"]='product';
                 $_SESSION["img_id2"]='home3';
                 echo  "<td><a href='batvest.php?pr={$row3['pid']}&st={$row3['sid']}'><img src='http://localhost/dress/test3.php?limit2={$cnt3},1' width='150' height='180'></a></td>";   //典籍圖片需跳至自己的商品頁
                 $cnt3++;
             }
           ?>   
        
         <td><a class="more" href="p_onsale.php">more...</a></td>
      </tr>
       <tr>    
          <td align='center'><img src="img/1.png" width="35" height="35"></a> </td>
          <td align='center'><img src="img/2.png" width="35" height="35"></a> </td>
          <td align='center'><img src="img/3.png" width="35" height="35"></a> </td>
      </tr> 
    </table>
  </div>
　　　　
</body>
</html>