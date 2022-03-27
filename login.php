<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>登入LOGIN</title>
	<link href="dress2.css" rel="stylesheet" type="text/css">
</head>

<body id="enter">
	<a href="home.php"><img src="img/logo.jpg" height="60" width="100"></a><br><br>
	<div id="login">
		<table id="tab_table">
			<tr>
				<th class="title_tab"><a href="<?php $_SERVER['PHP_SELF'] ?>?order=1">顧客</a></th>
				<th class="title_tab"><a href="<?php $_SERVER['PHP_SELF'] ?>?order=2">店家</a></th>
				<th class="title_tab"><a href="<?php $_SERVER['PHP_SELF'] ?>?order=3">管理者</a></th>

			</tr>
			<tr>
				<td>
					<?php
					if (empty($_GET['order']) || $_GET['order'] < 2 || $_GET['order'] > 3 || !is_numeric($_GET['order'])) {
						$order = 1;
						echo '<br>登入-顧客<br><br>';
					} elseif ($_GET['order'] == 2) {
						$order = 2;
						echo '<br>登入-店家<br><br>';
					} elseif ($_GET['order'] == 3) {
						$order = 3;
						echo '<br>登入-管理<br><br>';
					} 
					?>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<form method="post" action="login_check.php">
						<input type="hidden" name="id" value="<?php echo $order?>">   <!--傳遞參數判斷身分-->
						帳號:<input type="text" name="account"><br><br>
						密碼:<input type="password" name="password"><br><br>
						<input type="submit" name="login" value="登入">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" name="register" value="註冊" onClick="this.form.action='register.php';">
					</form>

				</td>
			</tr>

		</table>
	</div>


</body>

</html>