<?php
session_start();
if(empty($_COOKIE['lang'])) setcookie("lang","ru", time()+3600, "/","", 0);
	if(@$_COOKIE['lang'] == 'ru') {
		require_once('lang/ru/login.php');
	}
	else {
		require_once('lang/en/login.php');
	}
?>
<?php if((!isset($_COOKIE['id']) && empty($_COOKIE['id'])) || (!isset($_SESSION['id']) && empty($_SESSION['id']))) { ?>
<!DOCTYPE html>
<html>
<head>
<title>Вход</title>
<link href="css/main.css?1" rel="stylesheet">
<script src="scripts/lang.js"></script>
</head>
<body>
	<?php include('header.php');?>
	<main>
		<div class="wrap_form">
		<p class="exist_user"><?php if(isset($_GET['error']) && $_GET['error'] == 'true') echo $MESS['INCORRECT_LOGIN_OR_PASSWORD'];?><?php if(isset($_GET['empty']) && $_GET['empty'] == 'true') echo $MESS['EMPTY_VALUES'];?></p>
			<form action="Model/checkLogin.php" method="POST" id="login_form">
				<div class="outer"><input type="text" value="<?php if(isset($_GET['name']) && $_GET['name'] !== 'empty') echo $_GET['name'];?>" id="name" name="name" placeholder="<?php echo $MESS['LOGIN_NAME']; ?>"></div>
				<div class="outer"><input type="password" id="password" name="password" placeholder="<?php echo $MESS['LOGIN_PASSWORD']; ?>"></div>
				<input type="submit" name="submit_l" id="submit_1" value="<?php echo $MESS['LOGIN_SEND']; ?>">
			</form>
			<div class="registration">
				<a href="index.php"><?php echo $MESS['REGISTRATION']; ?></a>
			</div>
		</div>
	</main>
<script>
	 window.onload = function () {
		var submit = document.getElementById('submit_1');
		submit.onclick = function() {
			
			var elements = [
					document.getElementById('name'),
					document.getElementById('password')
				];
			for(i = 0; i < elements.length; ++i) {
				if(elements[i].value == '') {
					if (!elements[i].classList.contains("not-valid")) {
						span = createElementSpan('<?php echo $MESS['EMPTY_VALUE'];?>');
						elements[i].classList.add("not-valid");
						elements[i].after(span);
					}
					event.preventDefault();
				}
				else {
					if (elements[i].classList.contains("not-valid")) {
						elements[i].classList.remove("not-valid");
						var elem = elements[i].nextElementSibling;
						elements[i].parentNode.removeChild(elem);
					}
				}
			}
		}
	}
	function createElementSpan(text) {
		var span = document.createElement('span');
		span.className = "error";
		span.innerHTML = text;
		return span;
	}
 
</script>
</body>
</html>
<?php
}
else {
	header('Location: profile.php');
}