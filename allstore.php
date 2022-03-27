<?php
	include("mysql.inc.php");
	session_start();
	

    if(!empty($_GET["st"])){
        $sql = "SELECT * FROM stores WHERE sid ='{$_GET["st"]}'";
        $result = mysqli_query($conn,$sql);


        while($srow = mysqli_fetch_array($result)){
           $sid=$srow['sid'];
           $name=$srow['sname'];
           break;
        }
    }
	

    $perpage=6;

    if(!empty($_GET["st"])){
        $sql = "SELECT * FROM stores WHERE sid = '{$_GET["st"]}'";   //取得店家名字
        $result = mysqli_query($conn,$sql);
        while($srow = mysqli_fetch_array($result)){
          $_SESSION["sid"]=$srow['sid'];
          $sid=$srow['sid'];
          $name=$srow['sname'];
          $txt=$srow['stxt'];
          $phone=$srow['sphone'];
          break;
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
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $name?></title>
	<link href="dress_final.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div id = "left">
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
          <a class="more" href="<?php echo $imglink; ?>"><img src="<?php echo $img; ?>" width="20" height="20"></a>
            &nbsp;&nbsp;&nbsp;&nbsp;
      <?php echo $logout; ?>
		 
		</form>
	</div>
	<div id="right-shop">
		<?php 
		    $_SESSION['tablename'] = 'stores';
		    if(!empty($_REQUEST['st'])){
		    	$_SESSION["sid"] = $_REQUEST['st'];        
            }

            $stsql = "SELECT * FROM stores WHERE sid ={$_SESSION['sid']}";
            $stresult = mysqli_query($conn,$stsql);

            
            $_SESSION["img_id"]='allstore';
			while($row = mysqli_fetch_array($stresult)){
                // if($row["simg"] == NULL){
                //     echo "<img src='img/store.jpg' width='150' height='150'>";
                // }
                // else{
                //     //echo "<img src='http://localhost/dress/store_pic.php' width='150' height='150'>";
                //      echo  "<img src='http://localhost/dress/store_pic.php ' width='150' height='150'>";    
                // }
				
				echo "<h2>店家名稱:$row[2]</h2><br/><br/>
					  <p>店家簡介:$row[7]</p><br/><br/>
					  <h4>Email:$row[4]&nbsp;&nbsp;&nbsp;<br/>
					  連絡電話:$row[5]</h4><br/>";
			}

           
            
            //判斷sql語法
            if(!empty($_GET["sex"])){  
            	$_SESSION["sex"]=$_GET["sex"];

            	if($_GET["sex"]==1){   //男
            		$sql2="SELECT * FROM product WHERE (pclass='mtop' AND sid={$_SESSION["sid"]}) OR (pclass='mlower' AND sid={$_SESSION["sid"]})";
                    $_SESSION["img_id"]='sex1';

                    if(!empty($_GET["id"])){                    //點選種類
                            $id=$_GET["id"];
                    }    

                    if(!empty($_GET['p'])){      //點擊價錢篩選
                        $_SESSION['s']='';
            			$_SESSION['p']=$_GET['p'];
                        $_SESSION["choice"]='poprice';
            			if($_GET['p']==1){      //男-價錢 低->高
            				
            				$sql2="SELECT * FROM product WHERE (pclass='mtop' AND sid={$_SESSION["sid"]}) OR (pclass='mlower' AND sid={$_SESSION["sid"]}) ORDER BY poprice";
                            $_SESSION["img_id"]='p1';
                            
                            if(!empty($id)){         //種類
            					$id=$_GET["id"];
            					$_SESSION["class"]="m{$id}";

            					$sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]}";
            					$_SESSION["img_id"]='choice1';

                                if($id=='accessories'){
                                    $_SESSION["class"]='accessories';
                                    $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}  ORDER BY {$_SESSION["choice"]}";
                                    $_SESSION["img_id"]='nosex_choice1_class_accessories';
                                }
                                $id='';
            			    }

            			}
            			else{                      //男-價錢 高->低
                            $sql2="SELECT * FROM product WHERE (pclass='mtop' AND sid={$_SESSION["sid"]}) OR (pclass='mlower' AND sid={$_SESSION["sid"]})  ORDER BY poprice DESC";
                            $_SESSION["img_id"]='p2';

                            if(!empty($id)){         //種類
            					$id=$_GET["id"];
            					$_SESSION["class"]="m{$id}";

                                $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]} DESC";
            					$_SESSION["img_id"]='choice2';


                                if($id=='accessories'){
                                    $_SESSION["class"]='accessories';
                                    $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}  ORDER BY {$_SESSION["choice"]} DESC";
                                    $_SESSION["img_id"]='nosex_choice2_class_accessories';
                                }
                                $id='';
            				}
            			}
            		}
                    else{                                //沒有點擊價錢篩選
                        if(!empty($id)){         //種類
                                $id=$_GET["id"];
                                $_SESSION["class"]="m{$id}";

                                $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}";
                                $_SESSION["img_id"]='no_choice1';


                                if($id=='accessories'){
                                    $_SESSION["class"]='accessories';
                                    $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}";
                                    $_SESSION["img_id"]='no_choice1';
                                }
                        }
                    }

            		if(!empty($_GET['s'])){    //點擊銷售篩選
                    	$_SESSION["p"]='';     //歸0
                        $_SESSION['s']=$_GET['s'];
                        $_SESSION["choice"]='samount';

            		    if($_GET['s']==1){     //男-銷售量 低->高
            		    	$sql2="SELECT * FROM product WHERE (pclass='mtop' AND sid={$_SESSION["sid"]}) OR (pclass='mlower' AND sid={$_SESSION["sid"]}) ORDER BY samount";
                            $_SESSION["img_id"]='s1';

                             if(!empty($id)){         //種類
            					$id=$_GET["id"];
            					$_SESSION["class"]="m{$id}";

            					$sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]}";
            					$_SESSION["img_id"]='choice1';


                                if($id=='accessories'){
                                    $_SESSION["class"]='accessories';
                                    $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}  ORDER BY {$_SESSION["choice"]}";
                                    $_SESSION["img_id"]='nosex_choice1_class_accessories';
                                }
                                $id='';
            				  }
            		    }
            		    else{                      //男-銷售量 高->低
            		    	$sql2="SELECT * FROM product WHERE (pclass='mtop' AND sid={$_SESSION["sid"]}) OR (pclass='mlower' AND sid={$_SESSION["sid"]}) ORDER BY samount DESC";
            		    	$_SESSION["img_id"]='s2';

            		    		if(!empty($id)){        //種類
                            	$id=$_GET["id"];
            					$_SESSION["class"]="m{$id}";

            					$sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]} DESC";
            					$_SESSION["img_id"]='choice2';


                                if($id=='accessories'){
                                    $_SESSION["class"]='accessories';
                                    $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}  ORDER BY {$_SESSION["choice"]} DESC";
                                    $_SESSION["img_id"]='nosex_choice2_class_accessories';
                                }
                                $id='';
            				  }
            		    }
            		}
                    else{                                 //沒有點擊銷售篩選
                         if(!empty($id)){         //種類
                                $id=$_GET["id"];
                                $_SESSION["class"]="m{$id}";

                                $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}";
                                $_SESSION["img_id"]='no_choice1';


                                if($id=='accessories'){
                                    $_SESSION["class"]='accessories';
                                    $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}";
                                    $_SESSION["img_id"]='no_choice1';
                                }
                        }
                    }
            		
            	}
            	elseif($_GET["sex"]==2){   //女
            		$sql2="SELECT * FROM product WHERE (pclass='wtop' AND sid={$_SESSION["sid"]}) OR (pclass='wlower' AND sid={$_SESSION["sid"]})  OR (pclass='wonepiece' AND sid={$_SESSION["sid"]})";
                     $_SESSION["img_id"]='sex2';

                    if(!empty($_GET["id"])){                    //點選種類
                            $id=$_GET["id"];
                    }    

                     if(!empty($_GET['p'])){                    //點擊價錢篩選
            			$_SESSION['p']=$_GET['p'];
                        $_SESSION['s']='';
                        $_SESSION["choice"]='poprice';
            			if($_GET['p']==1){                    //女-價錢 低->高
            				$sql2="SELECT * FROM product WHERE (pclass='wtop' AND sid={$_SESSION["sid"]}) OR (pclass='wlower' AND sid={$_SESSION["sid"]})  OR (pclass='wonepiece' AND sid={$_SESSION["sid"]})  ORDER BY poprice";
                            $_SESSION["img_id"]='p3';

                             if(!empty($id)){         //種類
                             	$id=$_GET["id"];
            					$_SESSION["class"]="w{$id}";

            					$sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]}";
            					$_SESSION["img_id"]='choice1';


                                if($id=='accessories'){
                                    $_SESSION["class"]='accessories';
                                    $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}  ORDER BY {$_SESSION["choice"]}";
                                    $_SESSION["img_id"]='nosex_choice1_class_accessories';
                                }
                                $id='';
            				  }
            				  
            			}
            			else{                                  //女-價錢 高->低
                            $sql2="SELECT * FROM product WHERE (pclass='wtop' AND sid={$_SESSION["sid"]}) OR (pclass='wlower' AND sid={$_SESSION["sid"]})  OR (pclass='wonepiece' AND sid={$_SESSION["sid"]})  ORDER BY poprice DESC";
                            $_SESSION["img_id"]='p4';
                            
                               if(!empty($id)){         //種類
                               	$id=$_GET["id"];
            					$_SESSION["class"]="w{$id}";

            					$sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]} DESC";
            					$_SESSION["img_id"]='choice2';


                                if($id=='accessories'){
                                    $_SESSION["class"]='accessories';
                                    $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}  ORDER BY {$_SESSION["choice"]} DESC";
                                    $_SESSION["img_id"]='nosex_choice2_class_accessories';
                                }
                                 $id='';
            				    }
            			}
            		 }
                     else{      //沒有點擊價錢篩選
                         if(!empty($_GET["id"])){         //種類
                                $id=$_GET["id"];
                                $_SESSION["class"]="w{$id}";

                                $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}";
                                $_SESSION["img_id"]='no_choice1';

                                if($id=='accessories'){
                                    $_SESSION["class"]='accessories';
                                    $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}";
                                    $_SESSION["img_id"]='no_choice1';
                                }
                         }



                     }


            		
                    if(!empty($_GET['s'])){   //點擊銷售篩選
                    	$_SESSION["p"]='';     //歸0
                        $_SESSION['s']=$_GET['s'];
                        $_SESSION["choice"]='samount';
            		    if($_SESSION["s"]==1){     //女-銷售量 低->高
            		    	$sql2="SELECT * FROM product WHERE (pclass='wtop' AND sid={$_SESSION["sid"]}) OR (pclass='wlower' AND sid={$_SESSION["sid"]})  OR (pclass='wonepiece' AND sid={$_SESSION["sid"]}) ORDER BY samount";
                            $_SESSION["img_id"]='s3';

                            if(!empty($id)){         //種類
                            	$id=$_GET["id"];
            					$_SESSION["class"]="w{$id}";

            					$sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]}";
            					$_SESSION["img_id"]='choice1';


                                if($id=='accessories'){
                                    $_SESSION["class"]='accessories';
                                    $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}  ORDER BY {$_SESSION["choice"]}";
                                    $_SESSION["img_id"]='nosex_choice1_class_accessories';
                                }
                                 $id='';
            				  }


            		    }
            		    else{                      //女-銷售量 高->低
            		    	$sql2="SELECT * FROM product WHERE (pclass='wtop' AND sid={$_SESSION["sid"]}) OR (pclass='wlower' AND sid={$_SESSION["sid"]})  OR (pclass='wonepiece' AND sid={$_SESSION["sid"]}) ORDER BY samount DESC";
            		    	$_SESSION["img_id"]='s4';	

            		    	if(!empty($id)){         //種類
	                            $id=$_GET["id"];
            					$_SESSION["class"]="w{$id}";

            					$sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]} DESC";
            					$_SESSION["img_id"]='choice2';


                                if($id=='accessories'){
                                    $_SESSION["class"]='accessories';
                                    $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}  ORDER BY {$_SESSION["choice"]} DESC";
                                    $_SESSION["img_id"]='nosex_choice2_class_accessories';
                                }
                                 $id='';
            			    }
            		    }
            		}
                    else{                                 //沒有點擊銷售篩選              
                         if(!empty($id)){         //種類
                                $id=$_GET["id"];
                                $_SESSION["class"]="w{$id}";

                                $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}";
                                $_SESSION["img_id"]='no_choice1';

                                if($id=='accessories'){
                                    $_SESSION["class"]='accessories';
                                    $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}";
                                    $_SESSION["img_id"]='no_choice1';
                                }
                        }
                    }
            		
                }
                elseif($_GET["sex"]=='all'){
                	$sql2 = "SELECT * FROM product WHERE sid={$_SESSION["sid"]}";
                	$_SESSION["img_id"]='all';
                	$_SESSION["sex"]='';
                	$_SESSION["p"]='';
                	$_SESSION["s"]='';
                    $_SESSION["id"]='';
                }

               

            } 	
            else{   //沒有點擊 男/女 (之前有點過)     	
            	    //不分性別
                    //一開始進入商品頁的畫面(沒點選)   
                if(!empty($_SESSION["sex"]) && $_SESSION["sex"]==1){   //男
                    $sql2="SELECT * FROM product WHERE (pclass='mtop' AND sid={$_SESSION["sid"]}) OR (pclass='mlower' AND sid={$_SESSION["sid"]})";
                    $_SESSION["img_id"]='sex1';

                    if(!empty($_GET['p'])){      //點擊價錢篩選
                        $_SESSION['p']=$_GET['p'];
                         $_SESSION['s']='';

                        if( $_GET['p']==1){      //男-價錢 低->高
                            $sql2="SELECT * FROM product WHERE (pclass='mtop' AND sid={$_SESSION["sid"]}) OR (pclass='mlower' AND sid={$_SESSION["sid"]}) ORDER BY poprice";
                            $_SESSION["img_id"]='p1';
                        }
                        else{                      //男-價錢 高->低
                            $sql2="SELECT * FROM product WHERE (pclass='mtop' AND sid={$_SESSION["sid"]}) OR (pclass='mlower' AND sid={$_SESSION["sid"]})  ORDER BY poprice DESC";
                            $_SESSION["img_id"]='p2';
                        }
                    }
                    else{
                        if(!empty($_GET["id"])){                    //點選種類
                            $id=$_GET["id"];
                        }    
                        if(!empty($_SESSION["p"])){            //之前有點過價格篩選
                            if($_SESSION["p"]==1){             //價格低到高 
                              $_SESSION["choice"]='poprice';
                              if(!empty($id)){         //種類
                                $id=$_GET["id"];
                                $_SESSION["class"]="m{$id}";

                                $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]}";
                                $_SESSION["img_id"]='choice1';
                              }
                              $id='';
                            
                            }
                            else{                              //價格高到低 
                              if(!empty($id)){         //種類
                                $id=$_GET["id"];
                                $_SESSION["class"]="m{$id}";

                                $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]} DESC";
                                $_SESSION["img_id"]='choice2';
                              }
                              $id='';
                            }
                        }
                        else{                                  //之前沒點過價格篩選(有點過性別)
                            if(!empty($id)){           //種類
                                $id=$_GET["id"];
                                $_SESSION["class"]="m{$id}";

                                $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}"; //不用做排序
                                $_SESSION["img_id"]='no_choice1';
                            }

                        }
                    }
                   
                    if(!empty($_GET['s'])){    //點擊銷售篩選
                        $_SESSION["p"]='';     //歸0
                        $_SESSION['s']=$_GET['s'];

                        if($_SESSION["s"]==1){     //男-銷售量 低->高
                            $sql2="SELECT * FROM product WHERE (pclass='mtop' AND sid={$_SESSION["sid"]}) OR (pclass='mlower' AND sid={$_SESSION["sid"]}) ORDER BY samount";
                            $_SESSION["img_id"]='s1';
                        }
                        else{                      //男-銷售量 高->低
                            $sql2="SELECT * FROM product WHERE (pclass='mtop' AND sid={$_SESSION["sid"]}) OR (pclass='mlower' AND sid={$_SESSION["sid"]}) ORDER BY samount DESC";
                            $_SESSION["img_id"]='s2';   
                        }
                    }
                    else{   //沒有點擊篩選(之前有點過) 
                         if(!empty($_SESSION["s"])){           //之前有點過銷售篩選
                            $_SESSION["choice"]='samount';
                            if($_SESSION["s"]==1){             //銷售低到高

                              if(!empty($id)){         //種類
                                $id=$_GET["id"];
                                $_SESSION["class"]="m{$id}";

                                $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]}";
                                $_SESSION["img_id"]='choice1';
                              }
                              $id='';
                            
                            }
                            else{                             //銷售高到低

                              if(!empty($id)){        //種類
                                $id=$_GET["id"];
                                $_SESSION["class"]="m{$id}";

                                $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]} DESC";
                                $_SESSION["img_id"]='choice2';
                              }
                              $id='';
                            }
                         }
                         else{                                //之前沒點過價格篩選(有點過性別)
                            if(!empty($id)){          //種類
                                $id=$_GET["id"];
                                $_SESSION["class"]="m{$id}";

                                $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}"; //不用做排序
                                $_SESSION["img_id"]='no_choice1';
                            }
                         }
                    }

                }
                elseif(!empty($_SESSION["sex"]) && $_SESSION["sex"]==2){                   //女
                    $sql2="SELECT * FROM product WHERE (pclass='wtop' AND sid={$_SESSION["sid"]}) OR (pclass='wlower' AND sid={$_SESSION["sid"]})  OR (pclass='wonepiece' AND sid={$_SESSION["sid"]})";
                     $_SESSION["img_id"]='sex2';


                    if(!empty($_GET['p'])){                    //點擊價錢篩選
                        $_SESSION["s"]='';
                        $_SESSION['p']=$_GET['p'];

                        if( $_GET['p']==1){                    //女-價錢 低->高
                            $sql2="SELECT * FROM product WHERE (pclass='wtop' AND sid={$_SESSION["sid"]}) OR (pclass='wlower' AND sid={$_SESSION["sid"]})  OR (pclass='wonepiece' AND sid={$_SESSION["sid"]})  ORDER BY poprice";
                            $_SESSION["img_id"]='p3';
                        }
                        else{                                  //女-價錢 高->低
                            $sql2="SELECT * FROM product WHERE (pclass='wtop' AND sid={$_SESSION["sid"]}) OR (pclass='wlower' AND sid={$_SESSION["sid"]})  OR (pclass='wonepiece' AND sid={$_SESSION["sid"]})  ORDER BY poprice DESC";
                            $_SESSION["img_id"]='p4';
                        }
                    }
                    else{
                        if(!empty($_GET["id"])){                    //點選種類
                            $id=$_GET["id"];
                        }    
                        if(!empty($_SESSION["p"])){  //之前有點過價格篩選
                            $_SESSION["choice"]='poprice';      
                            if($_SESSION["p"]==1){             //價格低到高 
                              
                              if(!empty($id)){         //種類
                                $_SESSION["class"]="w{$id}";

                                $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]}";
                                $_SESSION["img_id"]='choice1';
                              }
                              $id='';
                            }
                            else{                              //價格高到低 
                              if(!empty($id)){         //種類
                                $_SESSION["class"]="w{$id}";

                                $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]} DESC";
                                $_SESSION["img_id"]='choice2';
                              }
                              $id='';
                            }
                                   
                        }
                        else{                                  //之前沒點過價格篩選(有點過性別)
                            if(!empty($id)){           //種類
                                $_SESSION["class"]="w{$id}";

                                $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}"; //不用做排序
                                $_SESSION["img_id"]='no_choice1';
                            }

                        }
                    }


                    if(!empty($_GET['s'])){   //點擊銷售篩選
                        $_SESSION["p"]='';     //歸0
                        $_SESSION['s']=$_GET['s'];

                        if($_SESSION["s"]==1){     //女-銷售量 低->高
                            $sql2="SELECT * FROM product WHERE (pclass='wtop' AND sid={$_SESSION["sid"]}) OR (pclass='wlower' AND sid={$_SESSION["sid"]})  OR (pclass='wonepiece' AND sid={$_SESSION["sid"]}) ORDER BY samount";
                            $_SESSION["img_id"]='s3';
                        }
                        else{                      //女-銷售量 高->低
                            $sql2="SELECT * FROM product WHERE (pclass='wtop' AND sid={$_SESSION["sid"]}) OR (pclass='wlower' AND sid={$_SESSION["sid"]})  OR (pclass='wonepiece' AND sid={$_SESSION["sid"]}) ORDER BY samount DESC";
                            $_SESSION["img_id"]='s4';   
                        }
                    }
                    else{
                        if(!empty($_GET["id"])){                    //點選種類
                            $id=$_GET["id"];
                        }    
                        if(!empty($_SESSION["s"])){            //之前有點過銷售篩選
                            $_SESSION["choice"]='samount';
                            if($_SESSION["s"]==1){             //價格低到高 
                              if(!empty($id)){         //種類
                                $_SESSION["class"]="w{$id}";

                                $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]}";
                                $_SESSION["img_id"]='choice1';
                              }
                              $id='';
                            }
                            else{                              //價格高到低 
                              if(!empty($id)){         //種類
                                $_SESSION["class"]="w{$id}";

                                $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]} DESC";
                                $_SESSION["img_id"]='choice2';
                              }
                              $id='';
                            }
                        }
                        else{                                  //之前沒點過價格篩選(有點過性別)
                            if(!empty($id)){           //種類
                                $id=$_GET["id"];
                                $_SESSION["class"]="w{$id}";

                                $sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}"; //不用做排序
                                $_SESSION["img_id"]='no_choice1';
                            }

                        }
                    }
                }
                else{    
            		$sql2="SELECT * FROM product WHERE sid={$_SESSION["sid"]}"; 
            	    $_SESSION["img_id"]='all';

                    if(!empty($_GET["id"])){                    //點選種類
            				$_SESSION["id"]=$_GET["id"];
            		} 


            	    if(!empty($_GET['p'])){                     //只點價錢篩選
            			$_SESSION["choice"]='poprice';
            			if( $_GET['p']==1){                     //價錢 低->高(店家全部商品)
            				$sql2="SELECT * FROM product WHERE sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]}";
                            $_SESSION["img_id"]='only_choice1';


            			}
            			else{                                   //價錢 高->低
                            $sql2="SELECT * FROM product WHERE sid={$_SESSION["sid"]}  ORDER BY {$_SESSION["choice"]} DESC";
                            $_SESSION["img_id"]='only_choice2';
            			}
            		}
            		else{   
            		        //沒點價錢篩選
                    	    //只點過種類
                    		if(!empty($_SESSION["id"])){           //種類
            					$_SESSION["class"]="w{$_SESSION["id"]}";
            					$_SESSION["class2"]="m{$_SESSION["id"]}";

            					$sql2="SELECT * FROM product WHERE (pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}) OR (pclass='{$_SESSION["class2"]}' AND sid={$_SESSION["sid"]})"; //不用做排序
            					$_SESSION["img_id"]='class';

            					if($_SESSION["id"]=='accessories'){
            						$_SESSION["class"]='accessories';
            						$sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}"; //不用做排序
            						$_SESSION["img_id"]='accessories';
            					}

            				}
            		}


            		if(!empty($_GET['s'])){                     //只點過銷售篩選
                        $_SESSION["choice"]='samount';
            			if($_GET['s']==1){                     //銷售 低->高(店家全部商品)
            				$sql2="SELECT * FROM product WHERE sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]}";
                            $_SESSION["img_id"]='only_choice1';
            			}
            			else{                                   //銷售 高->低
                            $sql2="SELECT * FROM product WHERE sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]} DESC";
                            $_SESSION["img_id"]='only_choice2';
            			}
            		}
            		else{     //沒點銷售篩選
            			      //銷售高到低 
                              //只點過種類
                            if(!empty($_GET["id"])){                    //點選種類
                               $_SESSION["id"]=$_GET["id"];
                            } 

                    		if(!empty($_SESSION["id"])){                   //種類
            					$_SESSION["class"]="w{$_SESSION["id"]}";
            					$_SESSION["class2"]="m{$_SESSION["id"]}";

            					$sql2="SELECT * FROM product WHERE (pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}) OR (pclass='{$_SESSION["class2"]}' AND sid={$_SESSION["sid"]})"; //不用做排序
            					$_SESSION["img_id"]='class';

            					if($_SESSION["id"]=='accessories'){
            						$_SESSION["class"]='accessories';
            						$sql2="SELECT * FROM product WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}"; //不用做排序
            						$_SESSION["img_id"]='accessories';
            					}
            				}
            		}
                } 		
            }






            
            if(!empty($sql2)){
                $_SESSION["sql1"]=$sql2;
            }
           
           
            $result=mysqli_query($conn,$_SESSION["sql1"]);
           
            
            $totalrow=mysqli_num_rows($result);
            $totalpage=ceil($totalrow/$perpage);    //總頁數

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

            
            $sql3="{$_SESSION["sql1"]} LIMIT {$_SESSION['start']},6";
            $result2 = mysqli_query($conn,$sql3);
            $result4 = mysqli_query($conn,$sql3);

            $sex='';
            $p='';
            $s='';
            if(!empty($_SESSION["sex"])) {
                  	if($_SESSION["sex"]==1){
                  		$sex='男';
                  	}
                  	else{
                  		$sex='女';
                  	}
            }

            

		?>



        <form method="get" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
        	性別:<select name="sex">
                    <option value="">請選擇
					<option value="1">男
					<option value="2">女	
				</select>&nbsp;&nbsp;

		    價格:<select name="p">
                    <option value="">請選擇
					<option value="1">低->高
					<option value="2">高->低
				</select>&nbsp;&nbsp;

			銷售:<select name="s">
                    <option value="">請選擇
					<option value="1">低->高
					<option value="2">高->低
				</select>&nbsp;&nbsp;

			種類:<select name="id">
                    <option value="">請選擇
					<option value="top">上身類
					<option value="lower">下身類
					<option value="onepiece">連身類
					<option value="accessories">配件	
				</select>

			<input name="submit" type="submit" value="查詢" style="background-color: #FFE4E1;color:#BC8F8F ">
			<input name="sex" type="submit" value="all" style="background-color: #FFE4E1;color:#BC8F8F ">
        </form>
        &nbsp;&nbsp;
      
        <?php echo "<p style='font-size:8px;'>性別:{$sex}</p>"; ?>
		<table id="store_table">
		     <tr>

			     
			     <?php
			     if(!empty($_GET['cnt'])){   //顯示圖片的分頁
                   $_SESSION["cnt"]=(6*($_GET['page']-1));
                 }
                 else{
                   $_SESSION["cnt"]=0;
                 }   


                 while($row2 = mysqli_fetch_array($result2)){
                   $_SESSION["tablename"]='product';
                   echo  "<td><a href='batvest.php?st={$row2['sid']}&pr={$row2['pid']}'><img src='http://localhost/dress/test.php?limit={$_SESSION["cnt"]},1' width='150' height='180'></a></td>";   //點擊圖片需跳至自己的商品頁
                   $_SESSION["cnt"]++;
                 }
                 ?>
            
			 </tr>
             <?php
             echo "<tr>";   
             while($row4=mysqli_fetch_array($result4)){
                 $sql_store="SELECT sname FROM stores WHERE sid={$row4['sid']}";  //搜尋商品店家名字
                 $result_store=mysqli_query($conn,$sql_store);

                 while($row3=mysqli_fetch_array($result_store)){
                    $sid=$row3["sname"];
                 }


                 if(!empty($row4['samount'])){
                    $samount=$row4['samount'];
                 }
                 else{
                    $samount=0;
                 }

                 echo "<td align='center'>{$row4['pname']}<br>{$sid}<br>NT. {$row4['poprice']}(已售出{$samount}件)<br>--{$row4['pdate']}--</td>";             
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
              echo sprintf("<a href='%s?page=%d&cnt=%d'>%d</a>",$_SERVER['PHP_SELF'],$i,$_SESSION["cnt"],$i);
           }
        }

    ?>

		
	</div>
</body>
</html>