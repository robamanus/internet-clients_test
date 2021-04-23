<?php
	//include_once 'handlers/visits_monitor.php';
	if(isset($_COOKIE['login']) && isset($_COOKIE['hash'])) {
		$cpu = new CPU();
		$user = $cpu->ChkAccCookies($_COOKIE['login'],$_COOKIE['hash']);
		if($user == '5hhrtytj34yrg45yhh5'){ ?>
			<!DOCTYPE html>
			<html>
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<title>Админ</title>
					<meta name="viewport" content="width=device-width, initial-scale=1.0">
					<meta name="description" content="">
					<meta Name="keywords" Content="">
					<meta name="robots" content="noindex, nofollow"/>
					<link rel="stylesheet" type="text/css" href="http://gikon.ru/css/styles.css" />
					<script type="text/javascript" src="http://gikon.ru/js/jquery-2.1.4.min.js"></script>
					<script type="text/javascript" src="http://gikon.ru/js/gikon.js"></script>
					<link rel="shortcut icon" href="http://gikon.ru/img/favicon.ico">
				</head>
				<body>
					<div class="wrapper">
						<div class="container" style='width:100%;'>
								
<?php
	require_once "core/models/Admin.php";
	$adm = new Admin();
	$adm->UserTree();
?>
						</div>	
					</div>
				</body>
			</html>
<?php 		return;
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Вход</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta Name="keywords" Content="">
		<meta name="robots" content="noindex, nofollow"/>
		<link rel="stylesheet" type="text/css" href="http://gikon.ru/css/styles.css" />
		<script type="text/javascript" src="http://gikon.ru/js/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="http://gikon.ru/js/gikon.js"></script>
		<link rel="shortcut icon" href="http://gikon.ru/img/favicon.ico">
	</head>
	<body>
		<div class="wrapper">
			<div class="container">
				<h1>Вход</h1>
				<div class="form">
					<input type="text" placeholder="Username" name="usr">
					<input type="password" placeholder="Password" name="psw">
					<button type="submit" id="login-button">Login</button>
				</div>
<?php
	require_once "core/models/Guest.php";
	$g = new Guest();
	$g->UserTree();
	//exit;
		/*foreach($adm->tree[1] as $k=>$v){
			if(is_array($v) == true){
				echo "<div style='cursor:pointer;'>&emsp" . $v . "</div>";
			}
			else{
				echo "<div>-" . $v . "</div>";
			}
			
		}*/
?>
			</div>
		</div>
	</body>
</html>