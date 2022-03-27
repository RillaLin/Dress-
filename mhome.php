<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Dress-服飾網站店家整合平台</title>
	<link href="dress.css" rel="stylesheet" type="text/css">
</head>
<body>

	<div id="left">
		<a href="home.php"><img src="img/logo.jpg" height="60" width="100"></a><br><br>
		<div id="list"><br>
			<ul id="u">
				<li class="point"><b>男</b><br></li>
				<ul id="uu">
					<li><a id="aa" href="mtop.html">上身類</a></li><br>
					<li><a id="aa" href="mlower">下身類</a></li>
				</ul>
				<li class="point"><b>女</b><br></li>
				<ul id="uu">
					<li><a id="aa" href="wtop.html">上身類</a></li><br>
					<li><a id="aa" href="wlower.html">下身類</a></li><br>
					<li><a id="aa" href="wonepiece.html">連身</a></li><br>
				</ul>
				<li><a id="aa" href="accessories.html">配件</a></li>
			</ul><br>
		</div>
		
	</div>

	<div id="top">
		
		<form name="sform" method="get" action="search.php">
			<a href="about.html">關於店家</a>&nbsp;&nbsp;
		  <a href="member.html">會員專區</a>&nbsp;&nbsp;
			<input type="text" name="search">
		  <input type="image" name="submit_btn" src="img/find.png" width="15" height="15" onClick="document.sform.submit();">&nbsp;&nbsp;&nbsp;&nbsp;
		  <a href="login.php">登入</a>&nbsp;|&nbsp;
		  <a href="register.php">註冊</a>&nbsp;&nbsp;&nbsp;&nbsp;
		  <a href="shoppingcart.php"><img src="img/shoppingcart.png" width="20" height="20"></a>
		  	&nbsp;&nbsp;&nbsp;&nbsp;
		</form>
	</div>

  <div id="right">
  	當季新品<br>
  	<div id="show">
  		
  	</div>      <!--當季新品-->
  	<br>
  	熱銷產品<br>
  	<div id="show">
  		<a href="shoppingcart.php"><img src="img/shoppingcart.png" width="20" height="20"></a>
  	</div>      <!--熱銷產品-->
  	<br>
  	促銷商品<br>
  	<div id="show">
  		<a href="shoppingcart.php"><img src="img/shoppingcart.png" width="20" height="20"></a>
  	</div>      <!--促銷商品-->
  	
  </div>
　　　　
</body>
</html>