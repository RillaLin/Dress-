<?php
include("mysql.inc.php");
session_start();

if(empty($_SESSION["loginMember"]) && empty($_SESSION["loginAccount"])){   //登出的狀態
    echo "<script>alert('前往登入~');location.href='login.php';</script>";
}
else{ 


  $sql = "SELECT * FROM members WHERE maccount = '{$_SESSION["loginAccount"]}'";
  $result = mysqli_query($conn,$sql);

  while($mrow = mysqli_fetch_array($result)){
    $mid=$mrow['mid'];
    $sumpoint = $mrow['sumpoint'];
    break;
  }
    
    $errMsg=''; 
    if (!empty($_REQUEST['comment'])) {
 
        $message = $_REQUEST['comment'];
    }
    else {
        $errMsg .= '您忘記輸入留言<br>';
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link href="dress0.css" rel="stylesheet" type="text/css">
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
      </ul>
      <br>
    </div>
  
  </div>
  
  <div id="top">
    <form name="form" method="get" action="search.php">
      <a href="about.php">關於店家</a>&nbsp;&nbsp;
      <a href="member.php">會員專區</a>&nbsp;&nbsp;
      <input type="text" name="search">
      <input type="image" name="submit_btn" src="img/find.png" width="15" height="15" onClick="document.sform.submit();">&nbsp;&nbsp;&nbsp;&nbsp;
      <a href="login.php">登入</a>&nbsp;|&nbsp;
      <a href="register.php">註冊</a>&nbsp;&nbsp;&nbsp;&nbsp;
      <a href="shoppingcart.php?id=2">
        <img src="img/shoppingcart.png" width="20" height="20">
      </a>
      &nbsp;&nbsp;&nbsp;&nbsp;
    </form>
  </div>
 	
  <?php
    if ($errMsg ==''){

          $pr = $_SESSION["pr"];
          $st = $_SESSION["st"];
        //開啟圖片檔
        $file = fopen($_FILES["wearpic"]["tmp_name"], "rb");
        //讀入圖片檔
        $fileContents = fread($file, filesize($_FILES["wearpic"]["tmp_name"])); 
        //圖片檔案資料編碼
        $fileContents = base64_encode($fileContents); 

        $date = date("Y-m-d");

        $sql="INSERT INTO `suggests`(mid,pid,sid,wearpic,suggest,sdate) VALUES('$mid','$pr','$st','$fileContents','$message','$date');";
        $result = mysqli_query($conn, $sql);

        if (mysqli_affected_rows($conn) > 0){
           echo '已成功分享照片<br>';

           $psql = "UPDATE members SET sumpoint = $sumpoint + 2 WHERE mid = $mid";
           $presult = mysqli_query($conn,$psql);
           if(mysqli_affected_rows($conn) > 0){
             echo "獲得2點點數<br/>";
           }
        }

        else {
           echo '分享照片失敗<br>';
        }
        echo " <p><a href='batvest.php?pr=$pr&st=$st'>回商品頁</a></p>";
    }

    else {
        echo $errMsg . '請按瀏覽器的上一頁鈕重新輸入<br>';
    }
  ?>


</body>
</html>