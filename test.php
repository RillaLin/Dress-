<?php
	include("mysql.inc.php");
	session_start();


	/*---抓取tablename的內容，若未定義會出錯---*/
	$tablename = $_SESSION["tablename"];

	$li = $_REQUEST['limit'];

	if(!empty($_SESSION["img_id"])){
		if($_SESSION["img_id"]=='home2'){
			$sql = "SELECT pimg FROM $tablename ORDER BY samount DESC LIMIT $li";
		}
		elseif ($_SESSION["img_id"]=='shoppingcart') {
			$sql = "SELECT pimg FROM $tablename WHERE mid={$_SESSION["mid"]} ORDER BY pid LIMIT $li";
		}

		elseif ($_SESSION["img_id"]=='product_class') {
			$sql = "SELECT * FROM product WHERE pclass= '{$_SESSION['class']}' LIMIT $li";
		}

		elseif($_SESSION["img_id"]=='hot'){
			$sql = "SELECT pimg FROM $tablename ORDER BY samount DESC LIMIT $li";
		}

        //店家頁
		elseif($_SESSION["img_id"]=='all'){           //全部
			$sql = "SELECT pimg FROM $tablename WHERE sid={$_SESSION["sid"]}  LIMIT $li";
		}

		elseif($_SESSION["img_id"]=='sex1'){           //男
			$sql = "SELECT pimg FROM $tablename WHERE (pclass='mtop' AND sid={$_SESSION["sid"]}) OR (pclass='mlower' AND sid={$_SESSION["sid"]}) LIMIT $li";
		}

		elseif($_SESSION["img_id"]=='p1'){           //男-價錢 低->高
			$sql = "SELECT pimg FROM $tablename WHERE (pclass='mtop' AND sid={$_SESSION["sid"]}) OR (pclass='mlower' AND sid={$_SESSION["sid"]}) ORDER BY poprice LIMIT $li";
		}

		elseif($_SESSION["img_id"]=='p2'){           //男-價錢 高->低
			$sql = "SELECT pimg FROM $tablename WHERE (pclass='mtop' AND sid={$_SESSION["sid"]}) OR (pclass='mlower' AND sid={$_SESSION["sid"]}) ORDER BY poprice DESC LIMIT $li";
		}

		elseif($_SESSION["img_id"]=='s1'){           //男-銷售 低->高
			$sql = "SELECT pimg FROM $tablename WHERE (pclass='mtop' AND sid={$_SESSION["sid"]}) OR (pclass='mlower' AND sid={$_SESSION["sid"]}) ORDER BY samount LIMIT $li";
		}

		elseif($_SESSION["img_id"]=='s2'){           //男-銷售 高->低
			$sql = "SELECT pimg FROM $tablename WHERE (pclass='mtop' AND sid={$_SESSION["sid"]}) OR (pclass='mlower' AND sid={$_SESSION["sid"]}) ORDER BY samount DESC LIMIT $li";
		}

        elseif($_SESSION["img_id"]=='choice1'){           //(種類)低->高
			$sql = "SELECT pimg FROM $tablename WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]} LIMIT $li";
		}

		 elseif($_SESSION["img_id"]=='choice2'){           //(種類)高->低
			$sql = "SELECT pimg FROM $tablename WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]} DESC LIMIT $li ";
		}

		elseif($_SESSION["img_id"]=='accessories'){           //(種類accessories)高->低
			$sql = "SELECT pimg FROM $tablename WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} LIMIT $li ";
		}

		elseif($_SESSION["img_id"]=='sex2'){           //女
			$sql = "SELECT pimg FROM $tablename WHERE (pclass='wtop' AND sid={$_SESSION["sid"]}) OR (pclass='wlower' AND sid={$_SESSION["sid"]})  OR (pclass='wonepiece' AND sid={$_SESSION["sid"]}) LIMIT $li";
		}

		elseif($_SESSION["img_id"]=='p3'){           //女-價錢 低->高
			$sql = "SELECT pimg FROM $tablename WHERE (pclass='wtop' AND sid={$_SESSION["sid"]}) OR (pclass='wlower' AND sid={$_SESSION["sid"]})  OR (pclass='wonepiece' AND sid={$_SESSION["sid"]}) ORDER BY poprice LIMIT $li";
		}

		elseif($_SESSION["img_id"]=='p4'){           //女-價錢 高->低
			$sql = "SELECT pimg FROM $tablename WHERE (pclass='wtop' AND sid={$_SESSION["sid"]}) OR (pclass='wlower' AND sid={$_SESSION["sid"]})  OR (pclass='wonepiece' AND sid={$_SESSION["sid"]}) ORDER BY poprice DESC LIMIT $li ";
		}

		elseif($_SESSION["img_id"]=='s3'){           //女-銷售 低->高
			$sql = "SELECT pimg FROM $tablename WHERE (pclass='wtop' AND sid={$_SESSION["sid"]}) OR (pclass='wlower' AND sid={$_SESSION["sid"]})  OR (pclass='wonepiece' AND sid={$_SESSION["sid"]}) ORDER BY samount LIMIT $li";
		}

		elseif($_SESSION["img_id"]=='s4'){           //女-銷售 高->低
			$sql = "SELECT pimg FROM $tablename WHERE (pclass='wtop' AND sid={$_SESSION["sid"]}) OR (pclass='wlower' AND sid={$_SESSION["sid"]})  OR (pclass='wonepiece' AND sid={$_SESSION["sid"]}) ORDER BY samount DESC LIMIT $li";
		}

		elseif($_SESSION["img_id"]=='class'){                     //只點種類
			$sql = "SELECT pimg FROM $tablename WHERE (pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}) OR (pclass='{$_SESSION["class2"]}' AND sid={$_SESSION["sid"]}) LIMIT $li";
		}

		elseif($_SESSION["img_id"]=='only_choice1'){              //只點篩選(低->高)
			$sql = "SELECT pimg FROM $tablename WHERE sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]} LIMIT $li";
		}

		elseif($_SESSION["img_id"]=='only_choice2'){              //只點篩選(高->低)
			$sql = "SELECT pimg FROM $tablename WHERE sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]} DESC LIMIT $li";
		}


		elseif($_SESSION["img_id"]=='nosex_choice1_class'){        //只點排序跟種類(低->高)
			$sql = "SELECT pimg FROM $tablename WHERE (pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}) OR (pclass='{$_SESSION["class2"]}' AND sid={$_SESSION["sid"]}) ORDER BY {$_SESSION["choice"]} LIMIT $li";
		}

		elseif($_SESSION["img_id"]=='nosex_choice2_class'){        //只點排序跟種類(高->低)
			$sql = "SELECT pimg FROM $tablename WHERE (pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]}) OR (pclass='{$_SESSION["class2"]}' AND sid={$_SESSION["sid"]}) ORDER BY {$_SESSION["choice"]} DESC LIMIT $li";
		}

        elseif($_SESSION["img_id"]=='no_choice1'){        //只點性別種類(沒有排序)
			$sql = "SELECT pimg FROM $tablename WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} LIMIT $li";
		}

		elseif($_SESSION["img_id"]=='accessories'){                     //只點飾品
			$sql = "SELECT pimg FROM $tablename WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} LIMIT $li";
		}

        elseif($_SESSION["img_id"]=='nosex_choice1_class_accessories'){                     //飾品 銷售 低->高
			$sql = "SELECT pimg FROM $tablename WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]} LIMIT $li";
		}

 
		elseif($_SESSION["img_id"]=='nosex_choice2_class_accessories'){                     //飾品 銷售 高->低
			$sql = "SELECT pimg FROM $tablename WHERE pclass='{$_SESSION["class"]}' AND sid={$_SESSION["sid"]} ORDER BY {$_SESSION["choice"]} DESC LIMIT $li";
		}

		elseif($_SESSION["img_id"]=='shoppingcart'){                    
			$sql = "SELECT pimg FROM $tablename WHERE  mid={$_SESSION['mid']} ORDER BY n LIMIT $li";
		}

		elseif($_SESSION["img_id"]=='s'){           //搜尋頁         
			$sql = "SELECT * FROM product WHERE pname LIKE {$_SESSION['StrSrh']} ORDER BY {$_SESSION["order_search"]} LIMIT $li";
		}

		elseif($_SESSION["img_id"]=='store'){                    
			$sql = "SELECT * FROM product WHERE sid = '{$_SESSION["sid"]}' ORDER BY pid LIMIT $li";
		}
		
       
       
        if(!empty($sql)){
        	$result = mysqli_query($conn,$sql);
 
	        while($row = mysqli_fetch_array($result)){
		       header("Content-Type: image/jpg");
		       echo base64_decode($row['pimg']);
	        }
        }

         if(!empty($sql2)){
        	$result = mysqli_query($conn,$sql2);
 
	        while($row = mysqli_fetch_array($result)){
		       header("Content-Type: image/jpg");
		       echo base64_decode($row['simg']);
	        }
        }


        
	}



	


?>