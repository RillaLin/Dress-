<?php
include("mysql.inc.php");
session_start();
  
   if(!empty($_REQUEST['pr']) && !empty($_REQUEST['st'])){
      $_SESSION["pr"] = $_REQUEST['pr'];
      $_SESSION["st"] = $_REQUEST['st'];
   }
    

  if(!empty($_SESSION["pr"]) && !empty($_SESSION["st"])){
      $s = "SELECT * FROM product WHERE pid ='{$_SESSION['pr']}' AND sid ='{$_SESSION['st']}'";
      $r = mysqli_query($conn,$s);
      while($row=mysqli_fetch_array($r)){
        $name = $row[2];
      }
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
    elseif ($_SESSION["loginMember"]=="r") {
      $member = "root.php";
      $img = "img/membership.png";
      $imglink = "root.php";
    }
  }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo $name; ?></title>
  <link href="dress_final.css" rel="stylesheet" type="text/css">
</head>
<body>
  <div id="left">
    <a href="home.php">
      <img src="img/logo.jpg" height="60" width="100">
    </a>
    <br>
    <br>
    <div id="list">
      <br>
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
      </ul>
      <br>
    </div>
  
  </div>
  
  <div id="top">
    <form name="form" method="get" action="search.php">
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
<form method="get" action="shoppingcart.php">
<div id="right">
  
<?php
    
   
    if(!empty($_SESSION["pr"]) && !empty( $_SESSION["st"])){
      $sql = "SELECT * FROM product WHERE pid ='{$_SESSION["pr"]}' AND sid ='{$_SESSION["st"]}'";
    }
    

    $result = mysqli_query($conn,$sql);
   
    $class = '';
    while($row=mysqli_fetch_array($result)){
      $sql2="SELECT sname FROM stores WHERE sid={$row['sid']}";
      $result2 = mysqli_query($conn,$sql2);

      while($row2=mysqli_fetch_array($result2)){
        $sname=$row2["sname"];
      }
      
      $name = $row[2];
    switch ($row[4]) {
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
        $class = '女連身';
        break;
      case 'accessories':
        $class = '配件';
        break;
    }

    if($row[11] > $row[12]){
      $price = "特價:NT.".$row[12];
    }
    else{
      $price = "原價:NT.".$row[11];
    }

    if($row[7] == 0 || $row[7] == NULL){   //s  缺貨中
      $row[7] = "缺貨中";
      echo "<input type='hidden' name='s_soldout' value='soldout'>";
    }
    else{
      $_SESSION["sa"]=$row[7];
    }

    if($row[8] == 0 || empty($row[8])){    //m 缺貨中
      $row[8] = "缺貨中";
      echo "<input type='hidden' name='m_soldout' value='soldout'>";
    }
    else{
       $_SESSION["ma"]=$row[8];    //傳現貨數
    }

    if($row[9] == 0 || empty($row[9])){    //l 缺貨中
      $row[9] = "缺貨中";
      echo "<input type='hidden' name='l_soldout' value='soldout'>";
    }
    else{
       $_SESSION["la"]=$row[9];     //傳現貨數
    }

        echo"<table border='0'>
            <tr>
              <td rowspan='11'><img src='http://localhost/dress/product_img.php?pid={$_SESSION["pr"]}&sid={$_SESSION["st"]}' width='400'></td>
              <th>$row[2]</th>
              
            </tr>
            <tr>
              <td>$class</td>
              <td><a href='allstore.php?st={$_SESSION["st"]}'>$sname</a></td>
            </tr>
            <tr>";
                echo"<td><input type='radio' name='pstyle' value='$row[5]'>$row[5]</td>";
            echo"</tr>
            <tr>

              <td><input type='radio' name='psize' value='s'>S</td>
              <td><input type='radio' name='psize' value='m'>M<td>
              <td><input type='radio' name='psize' value='l'>L</td>
              
              <td><input type='hidden' name='pid' value='{$_SESSION['pr']}'></td>
              <td><input type='hidden' name='sid' value='{$_SESSION["st"]}'></td>

            </tr>
            <tr>
              <td>S size</td>
              <td>M size</td>
              <td>L size</td>
            </tr>
            <tr>
              <td>$row[7]</td>
              <td>$row[8]</td>
              <td>$row[9]</td>
            </tr>
            <tr>
              <td><h3>$price</h3></td>
            </tr>
            <tr>
              <td><h6>上架日期:$row[13]</h6></td>
              <td><input type='submit' value='加入購物車'></td>
              <td><img  src='img/shoppingcart.png' width='60' height='60'></td>
            </tr> 
            </table><br/><hr class='style-two'><br/>
            $row[14]";

    }  
  ?>
  </form>
    <?php
    $salesql = "SELECT suggests.mid,suggests.sdate,suggests.suggest,members.mname FROM suggests,members WHERE suggests.mid = members.mid AND suggests.pid={$_SESSION['pr']} AND suggests.sid = {$_SESSION['st']} ORDER BY suggests.sdate DESC";
    $saleresult = mysqli_query($conn,$salesql);
    $nrow = mysqli_num_rows($saleresult);

    $cnt = 0;
    $_SESSION["tablename"] = 'suggests';

    if($nrow > 0 ){
      while ($row = mysqli_fetch_array($saleresult)) {            
        echo "$row[3]&nbsp;&nbsp;($row[1])<br/>
              $row[2]
              <img src = 'http://localhost/dress/suggest_img.php?limit=$cnt,1' width='150'>
              <br/><hr calss = 'style-two'>";
              $cnt ++;
      }
    }

  ?>
     <br/><br/><b class="big">留言或建議:</b>
     <form method="post" action="book2.php" enctype="multipart/form-data"><br/>
      
     分享你的穿搭圖片<input type = "file" name="wearpic" accept=".png,.jpg" required><br/><br/>
     <input type='hidden' name='mid' value='$mid'>

     <textarea name="comment" rows="6" cols="70" required></textarea><br>
     <input type ="submit" value="送出">
     </form>
</div>
</body>
</html>