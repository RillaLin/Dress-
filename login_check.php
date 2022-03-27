<?php
   header("Content-Type:text/html;charset=utf8");
   session_start();

  
    if(!empty($_POST['id']) && !empty($_POST["account"]) && !empty($_POST["password"])){
       include("mysql.inc.php");
       $a=$_POST["account"];
       $p=$_POST["password"];

       if($_POST['id']==1){   //顧客登入
         $sql="SELECT * FROM members WHERE maccount='$a' AND mpsd='$p'";
         $result=mysqli_query($conn,$sql);
         $rows=mysqli_num_rows($result);   //返回一個數值
         if($rows){  //0 false 1 true
           $_SESSION["loginMember"]="c";   //身份
           $_SESSION["loginAccount"]=$a;   //帳號
           echo "<script>alert('登入成功~');location.href='home.php';</script>";
           exit;
         }
         else{
           echo "<script>alert('帳號/密碼錯誤!!');location.href='login.php';</script>";

         }
       }
       elseif ($_POST['id']==2) {   //店家登入
         $sql="SELECT * FROM stores WHERE saccount='$a' AND spsd='$p'";
         $result=mysqli_query($conn,$sql);
         $rows=mysqli_num_rows($result);   //返回一個數值
         if($rows){  //0 false 1 true
           $_SESSION["loginMember"]="s";
           $_SESSION["loginAccount"]=$a;
           echo "<script>alert('登入成功~');location.href='store.php';</script>"; 
           exit;
         }
         else{
           echo "<script>alert('帳號/密碼錯誤!!');location.href='login.php?';</script>";
         }
       }
        elseif ($_POST['id']==3) {   //管理者登入
         $sql="SELECT * FROM root WHERE raccount='$a' AND rpsd='$p'";
         $result=mysqli_query($conn,$sql);
         $rows=mysqli_num_rows($result);   //返回一個數值
         if($rows){  //0 false 1 true
           $_SESSION["loginMember"]="r";
           $_SESSION["loginAccount"]=$a;
           echo "<script>alert('登入成功~');location.href='root.php';</script>";
           exit;
         }
         else{
           echo "<script>alert('帳號/密碼錯誤!!');location.href='login.php';</script>";
         }
       }
       
     }
   
   
?>