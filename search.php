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
 
    if(!empty($_POST["search"])){//關鍵字

     $_SESSION["wordSrh"]=$_POST["search"];
  }
  if(!empty($_SESSION["wordSrh"])){         
     $_SESSION["StrSrh"] ="'%".$_SESSION["wordSrh"]."%'";
  }
  
  if(!empty($_SESSION["StrSrh"])){
     if(!empty($_GET["choice"])){ 
      if($_GET["choice"]=="p1"){
        $_SESSION["order_search"]='poprice';
      }
      elseif($_GET["choice"]=="p2"){
        $_SESSION["order_search"]='poprice DESC';
      }
      elseif($_GET["choice"]=="s1"){
        $_SESSION["order_search"]='samount';
      }
      elseif($_GET["choice"]=="s2"){
        $_SESSION["order_search"]='samount DESC';
      }
        elseif($_GET["choice"]=="d1"){
        $_SESSION["order_search"]='pdate';
      }
      elseif($_GET["choice"]=="d2"){
        $_SESSION["order_search"]='pdate DESC';
      }   
     }
     else{   //沒點擊下拉是選單
        if(!empty($_SESSION["order_search"])){
            //保留剛選擇的
        }
        else{
            $_SESSION["order_search"]='poprice';   //預設
        }

     }

     if(!empty($_SESSION["order_search"])){
      $sql2="SELECT * FROM product WHERE pname Like {$_SESSION['StrSrh']} ORDER BY {$_SESSION["order_search"]}";

     }

     $perpage=6;
     $result3=mysqli_query($conn,$sql2);

     $numRows=mysqli_num_rows($result3);  //搜尋商品總筆數
    

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
   
  }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>搜尋結果</title>
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
		<table>
      
         <form method="get" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
          篩選:<select name="choice">
          <option value="">請選擇
          <optgroup label="價錢">
            <option value="p1">低->高
            <option value="p2">高->低
          </optgroup>
          <optgroup label="銷售">
            <option value="s1">低->高
            <option value="s2">高->低
          </optgroup>
          <optgroup label="上架">
            <option value="d1">舊->新
            <option value="d2">新->舊
          </optgroup>
        </select>&nbsp;&nbsp;
        <input name="submit" type="submit" value="查詢" style="background-color: #FFE4E1;color:#BC8F8F ">
         </form>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:15px;">--共搜尋到 <?php echo $numRows; ?> 筆 ' <?php echo $_SESSION["wordSrh"]; ?> ' 商品--<br><br></span>

        <?php 
        if(!empty($_SESSION["order_search"])){
            $sql="SELECT * FROM product WHERE pname Like {$_SESSION['StrSrh']} ORDER BY {$_SESSION["order_search"]} LIMIT {$_SESSION['start']},6";
        }

         $result=mysqli_query($conn,$sql);
         $result2=mysqli_query($conn,$sql);
        $numRows2=mysqli_num_rows($result2);


        echo "<tr>";
        
                if(!empty($_GET['cnt'])){   //顯示圖片的分頁
                   $_SESSION["cnt"]=(6*($_GET['page']-1));
                }
                else{
                   $_SESSION["cnt"]=0;
                }   
          
          while($row=mysqli_fetch_array($result)){
                 $_SESSION["tablename"]='product';
                 $_SESSION["img_id"]='s';
                 echo  "<td><a href='batvest.php?pr={$row['pid']}&st={$row['sid']}'><img src='http://localhost/dress/test.php?limit={$_SESSION["cnt"]},1' width='150' height='180'></a></td>";   //典籍圖片需跳至自己的商品頁    

                 $name=$row['pname'];
                 
                 $_SESSION["cnt"]++;
          }

            echo "</tr>"; 
            echo "<tr>";  
          while($row2=mysqli_fetch_array($result2)){
             $sql_store="SELECT sname FROM stores WHERE sid={$row2['sid']}";  //搜尋商品店家名字
             $result_store=mysqli_query($conn,$sql_store);

             while($row3=mysqli_fetch_array($result_store)){
              $sid=$row3["sname"];
             }
                 echo "<td align='center'>{$row2['pname']}<br>$sid<br>NT. {$row2['poprice']}(已售出{$row2['samount']}件)<br>--{$row2['pdate']}--</td>";           
          }
            echo "</tr>";
          
       
       
    ?>
      </table>

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