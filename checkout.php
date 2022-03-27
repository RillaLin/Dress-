<?php
  include ("mysql.inc.php");
  session_start();
  
      if(!empty($_SESSION["loginAccount"])){   //取得會員名稱和帳號
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
              break;
             }
      }

           
      //尋找放入購物車的資料(藉由mid判斷資料表有哪幾筆商品是當前使用者放入購物車的)
      $sql_s="SELECT * FROM sales WHERE mid={$_SESSION['mid']};";
  	  $result_s = mysqli_query($conn,$sql_s);
      $s_num=0;
  	  $s_num=mysqli_num_rows($result_s);   //sales資料表的筆數

     
   	  $sql_point="SELECT sumpoint FROM members WHERE mid={$_SESSION['mid']}";    //會員點數
      $point = mysqli_query($conn,$sql_point);

      while($row_p = mysqli_fetch_array($point)) {
      	$p=$row_p["sumpoint"];
      }

      
      $freight_fee=0;
      $fee='60';
      $_SESSION["fee"]='';
      if(!empty($_GET["fee"])){       //折抵點數   	  	
      	if(!empty($p)) {
      		if($p>=60){
      		   $_SESSION["fee"]=0;
      		   $fee='';  
      		   $p=$p-60;	 
      		   $freight_fee=1;
      		   echo"<script>alert('運費折抵成功~');</script>";   		
      	    }
      	    else{
               echo"<script>alert('點數不足喔!');</script>";
      	    }      	         	
      	}      		  	 
      }

      $amount=1;
      if(!empty($_POST["cash"]) && !empty($_POST["deliver"])){    //結帳
      	while($row = mysqli_fetch_array($result_s)){
  	  	    $payfor=$row["sid"];
  	  	    $pname=$row["pname"];
  	  	    $pstyle=$row["pstyle"];
            $psize=$row["psize"];
            $price=$row["price"];
            $pid=$row["pid"];
            
            if(!empty($_GET["$amount"])){
      	  	   $_SESSION["a"]=$_GET["$amount"];          //數量
      	    }

            date_default_timezone_set('Asia/Taipei');
   	        $now=date("Y-m-d H:i:s");
            
   	            if(!empty($_SESSION["a"])){
                    $per_price=$_SESSION["a"]*$price;
                   
      	            $sql_checkout="INSERT INTO `checkout`(cdate,mid,payfor,total,pname,pstyle,psize,oamount,price,cash,deliver,fee) VALUES('$now',{$_SESSION['mid']},$payfor,$per_price,'$pname','$pstyle','$psize',{$_SESSION["a"]},$price,'{$_POST['cash']}','{$_POST['deliver']}',$freight_fee);";

      	            // 增加商品銷售數量
      	            $sql_product="SELECT samount FROM product WHERE pid=$pid AND sid=$payfor";
      	            $p_result=mysqli_query($conn,$sql_product);

                    while($row2 = mysqli_fetch_array($p_result)){
                    	$samount = $row2["samount"];
                    }

                    if(!empty($samount)){
                    	 $samount2=$samount+$_SESSION["a"];
                    }
                    else{
                    	 $samount2=1;
                    }
                   
                    $samount_update="UPDATE `product` SET samount=$samount2 WHERE pid=$pid AND sid=$payfor;" ;  
                    $s_update = mysqli_query($conn,$samount_update); 


                    //減少商品庫存數量
                    if($psize=='s'){
                    	$size='psamount';
                    }
                    elseif($psize=='m'){
                    	$size='pmamount';
                    }
                    else{
                    	$size='plamount';
                    }
                    
                    $sql_size="SELECT $size FROM product WHERE pid=$pid AND sid=$payfor";
      	            $size_result=mysqli_query($conn,$sql_size);

                    while($row3 = mysqli_fetch_array($size_result)){
                    	$size_amount = $row3["$size"];
                    }

                    if(!empty($size_amount)){
                    	 $size_amount=$size_amount-$_SESSION["a"];
                    }
                    
                    $size_update="UPDATE `product` SET $size= $size_amount WHERE pid=$pid AND sid=$payfor;" ;  
                    $size_result = mysqli_query($conn,$size_update); 


                    $result_checkout = mysqli_query($conn,$sql_checkout);
   	            }
   	            
   	        	
            $amount++;
        }
        if(mysqli_affected_rows($conn) > 0){           
            echo "<script>alert('結帳成功~')</script>";   
            //清空該會員的購物車
            $sql_del="DELETE FROM `sales` WHERE mid={$_SESSION['mid']}"; 
            $del = mysqli_query($conn,$sql_del); 
        }
        else{
        }

        if($_SESSION["fee"]==0){      //減少會員點數
             $fee_sql="UPDATE `members` SET sumpoint=$p WHERE mid={$_SESSION['mid']};";
      		 $fee_result = mysqli_query($conn,$fee_sql);

        }
      }
      
      $sql_sales="SELECT * FROM sales;";        
      $sales = mysqli_query($conn,$sql_sales);
      $n= mysqli_num_rows($sales);
      $checkout=0;
      if($n==0){   //已結帳(購物車已清空)
      	$checkout=1;
      }
      else{       
      }
     
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>購物車</title>
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
      <a class="more" href="<?php echo $imglink; ?>"><img src="<?php echo $img; ?>" width="20" height="20"></a>
        &nbsp;&nbsp;&nbsp;&nbsp;
      <?php echo $logout; ?>
		</form>
	</div>

	<div id="right-shop">
		<div id="r2">
		   	<div id="wrapper">	
		   		<div id="title">
		   			<h1>Payment</h1>
		   		</div><br>
		   		<form name="sform" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
		   	    
		   		<div id="payment">
		   		付款方式: <select name="cash">
		   			<option value="cash">超商貨到付款</option>
		   			<option value="card">線上信用卡付款</option>
		   		</select><br><br>
		   		取貨方式: <select name="deliver">
		   			<option>7-11超商取貨</option>
		   			<option>OK/全家/萊爾富 超商取貨</option>
		   		</select><br><br><br><br>
		   		運費:<?php echo $_SESSION["fee"]; echo $fee; ?>&nbsp;&nbsp;&nbsp;點數:<?php echo $p; ?>
		   		    <?php
		   		    if($fee==''){
		   		    	echo "已折抵運費<br>";	
		   		    }
		   		    else{
		   		    	echo "<a href='checkout.php?fee=1'><input type='button' name='點數折抵'' value='點數折抵'></a><br><br>";
		   		    }

		   		    if($checkout == 0){    //還沒結帳
		   		    	echo"<input type='submit' name='結帳' value='結帳'>";
		   		    }
		   		    else{
		   		    	echo "結帳成功~!<br><br>";
		   		    	echo "<a href='home.php'><input type='button' name='checklist' value='回首頁'></a>";

		   		    }
		   		    
		   		    ?>
		   		    
		   		    <!--<a href='checkout.php'><input type="button" name="checklist" value="下一步"></a><br><br>-->
                </div>
                </form>
		   		
                <br><br><br>
		   	</div>
		   	<br>
	    </div>
	    <div id="r2-2-shop">
	    	<img src="">&nbsp;&nbsp;
			<?php
				echo "<h3>會員名稱:$name</h3>";
				echo '<br/>';
				echo "<h4>會員帳號:$account</h4>";
				echo '<br/>';
			?>

			<a href="membername.php"><input id="membername" type="button" value="修改會員名稱" style="background-color: #FFE4E1;color:#BC8F8F "></a><br>
			<a href="memberpsd.php"><input id=" memberpsd" type="button" value="修改會員密碼" style="background-color: #FFE4E1;color:#BC8F8F "></a>
	    </div>

	</div>


</body>
</html>