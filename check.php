<?php
  include ("mysql.inc.php");
  session_start();

      $sql_sales="SELECT * FROM sales;";        
      $sales = mysqli_query($conn,$sql_sales);
      $n= mysqli_num_rows($sales);
      if($n==0){
          echo "<script>alert('請添加商品到購物車!');location.href='shoppingcart.php';</script>";
      }

       

        
        if(!empty($_POST['class'])){    //取得下拉式選單得到的值
            $class = $_POST['class'];
        }
        else{
            $class = '1';
        }


        
        if(empty($_SESSION["loginMember"]) && empty($_SESSION["loginAccount"])){   //登出的狀態
    	    echo "<script>alert('前往登入~');location.href='login.php';</script>";
        }
        else{    //已登入
          $logout = "<a class='more' href='logout.php'>登出</a>";
          $login = $_SESSION["loginAccount"];

          if($_SESSION["loginMember"]=="c"){          //判斷不同身分會員專區的建立
      
            $member="member.php";
            $img="img/shoppingcart.png";
            $imglink="shoppingcart.php";
          }
    	    if(!empty($_GET["del"])){       //要從購物車刪除的商品id
    	      $del=$_GET["del"];
    	      $sql_del="DELETE FROM `sales` WHERE n={$del} AND mid={$_SESSION["mid"]};";  //刪除一筆資料
    	      $result_del = mysqli_query($conn,$sql_del);
    	      if(mysqli_affected_rows($conn) > 0){
    	 	     echo "<script>alert('商品已刪除');</script>";
    	      }  
    	      else{
                 //商品沒刪除
    	      }
        }

    
	
	        if(!empty($_SESSION["loginAccount"])){   //取得會員名稱和帳號
		       $memsql = "SELECT * FROM members WHERE maccount='{$_SESSION["loginAccount"]}';";
	           $result2 = mysqli_query($conn,$memsql);
	           while($mrow = mysqli_fetch_array($result2)){
		          $_SESSION["mid"]=$mrow['mid'];
		          $name=$mrow['mname'];
		          $account=$mrow['maccount'];
		          break;
	           }
	        }
  
            if(!empty($_GET["pid"]) && !empty($_GET["sid"])){   //商品按放入購物車後執行
            	
                $_SESSION["pid_cart"]=$_GET["pid"];
            	  $_SESSION["sid_cart"]=$_REQUEST["sid"];


               if(!empty($_SESSION["pid_cart"]) && !empty($_SESSION["sid_cart"])){   //判斷是否有東西放入購物車   
  	              $sql="SELECT * FROM product WHERE pid='{$_SESSION['pid_cart']}' AND sid='{$_SESSION['sid_cart']}';";
                  $result = mysqli_query($conn,$sql);
                  $result3 = mysqli_query($conn,$sql);  //同一結果物件不能被mysqli_fetch_array兩次

  	            //開啟圖片檔


                  while($row = mysqli_fetch_array($result3)){ 
                  	  if($row[11] > $row[12]){
      				            $price = $row[12];
    			  	        }
    			            else{
      				            $price = $row[11];
    			            }

  	                  $sid=$row["sid"];
  	                  $pname=$row["pname"];
  	                  $pimg=$row["pimg"];
  	                  break;
  	              }

  	              //加入購物車的商品資訊放入sales資料表(mid,pid是主鍵,不能重複,否則無法insert)
                  if(!empty($_GET['pstyle']) && !empty($_GET['psize'])){
                    if(!empty($_REQUEST['s_soldout']) && ($_REQUEST['psize']=='s')){
                       echo "<script>alert('s尺寸缺貨中...');location.href='batvest.php';</script>";
                    }
                    elseif(!empty($_REQUEST['m_soldout']) && ($_REQUEST['psize']=='m')){
                       echo "<script>alert('m尺寸缺貨中...');location.href='batvest.php';</script>";
                    }
                    elseif(!empty($_REQUEST['l_soldout']) && ($_REQUEST['psize']=='l')){
                       echo "<script>alert('l尺寸缺貨中...');location.href='batvest.php';</script>";
                    }
                    else{
                      $_SESSION["size"]=$_REQUEST['psize'];
                        
                      
                      $sql_i="INSERT INTO `sales`(pid,mid,sid,pimg,pname,pstyle,psize,price) VALUES({$_SESSION["pid_cart"]},{$_SESSION["mid"]},$sid,'$pimg','$pname','{$_REQUEST['pstyle']}','{$_REQUEST['psize']}',$price);";

                  
                      $result_i = mysqli_query($conn,$sql_i);
                      if(mysqli_affected_rows($conn) > 0){
                        
                        echo "<script>alert('加入購物車~');location.href='shoppingcart.php';</script>";
                        //重新執行頁面，使$_GET["id"]變為空的(再判斷一次$_GET["id"]值是否為空) 
                      }
                    }
                   
                  }
                  elseif(empty($_REQUEST['pstyle']) && !empty($_REQUEST['psize'])){
                      echo "<script>alert('請選擇商品樣式~');location.href='batvest.php';</script>";
                  }
                  elseif(empty($_REQUEST['psize']) && !empty($_REQUEST['pstyle'])){
                      echo "<script>alert('請選擇商品尺寸~');location.href='batvest.php';</script>";
                  }
                  else{
                      echo "<script>alert('請選擇商品樣式及尺寸~');location.href='batvest.php';</script>";
                  }
  	              
                }
            }
            else{
  	            //$cid=0;//cart編號
                $pname="";
                $pimg="";
                $price="";
                $ping="";
                $pstyle="";
                $psize="";
                $oamount="";
                $image="img/bag.png";
            }

            //尋找放入購物車的資料(藉由mid判斷資料表有哪幾筆商品是當前使用者放入購物車的)
            $sql_s="SELECT * FROM sales WHERE mid={$_SESSION['mid']};";
  	        $result_s = mysqli_query($conn,$sql_s);
            $s_num=0;
  	        $s_num=mysqli_num_rows($result_s);   //sales資料表的筆數
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

	<div id="right-shop">
		<div id="r2"><br/><br/>
		   	<div id="wrapper">	
		   		<div id="title">
		   			<h2>Checkout List(<?php echo $s_num ?>件)</h2>
		   		</div><br>
                
		   		<table border="0" id="cart_table">   <!--HTML表格欄寬分配-->
		   	     
          <form method="get" action="checkout.php">
		   		<?php
		   		    if($s_num!=0){
		   		     $cnt = 0;
		   		     echo "<tr>
		   		        <td></td>
                  <td>名稱</td>
                  <td>樣式</td>
		   		        <td>價格</td>
		   		        <td>數量</td>
                  <td>小計</td>
                  <td></td>
		   		        </tr>"; 
                
                $select=1;
                $all_price=0;
		   		      while($row = mysqli_fetch_array($result_s)){
                    $_SESSION["tablename"]='sales';
                    $_SESSION["img_id"]='shoppingcart';
                    
                    $sid=$row["sid"];

                    echo "<tr>
                        	  <td><img src='http://localhost/dress/test.php?limit={$cnt},1' width='130'></td>"; 

                         //商品照片-limit x,y 從第x筆取y筆資料
		   	            echo "<td>{$row['pname']}</td>";  //商品資訊

                   
                    echo "<td>{$row['pstyle']}&nbsp;&nbsp;&nbsp;{$row['psize']}</td>";
                    
		   	            echo "<td>NT.{$row['price']}</td>";
		   	         
                    if(!empty($_POST["$select"])){    //取得商品數量
                         $a=$_POST["$select"];
                         echo"<input type='hidden' name='$select' value='{$_POST["$select"]}'>";   //傳數量參數
                    }
                    echo"<td>x $a</td>";
                    
                    
                    $pre_price=$row['price']*$a;     
                    echo"<td>NT. $pre_price</td>";  //小計
		   	           
		   	            echo "</tr>";
		   	            $cnt++;
                    $select++;
                    $all_price=$all_price+$pre_price;
                    
		   		      } 

                echo "<tr>";   
                      echo "<td></td>"; 
                      echo "<td></td>"; 
                      echo "<td></td>"; 
                      echo "<td></td>"; 
                      echo "<td></td>"; 
                      echo "<td>總金額 NT.$all_price</td>";  
                      echo "<input type='hidden' name='all_price' value='$all_price'>";   //傳總金額參數
                echo "</tr>";  
                 
		   		    }
		   		    else{
		   		      $x='x';
		   		      echo "<tr>";   
                      echo "<td><img src='img/bag.png' width='150'></td>";  
		   	        echo "</tr>";  
                
		   		    }
		   		    echo "</table>";
		   	    ?>    
        <br><br>
        <input type="submit" name="checklist" value="下一步"><br><br>
		   	</div>
        <form>
		   	<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       
       
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