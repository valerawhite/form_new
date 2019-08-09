<?php
session_start();
require_once('Model/viewProfile.php');
if(empty($_COOKIE['lang'])) setcookie("lang","ru", time()+3600, "/","", 0);
	if(@$_COOKIE['lang'] == 'ru') {
		require_once('lang/ru/profile.php');
	}
	else {
		require_once('lang/en/profile.php');
	}
?>
<?php if((isset($_COOKIE['id']) && !empty($_COOKIE['id'])) || (isset($_SESSION['id']) && !empty($_SESSION['id'])) ) { ?>
<!DOCTYPE html>
<html>
<head>
<title>Профиль пользователя</title>
<link href="css/main.css" rel="stylesheet">
<script src="scripts/lang.js"></script>
</head>
<body>
	<?php include('header.php');?>
	<main>
		<div class="wrap_picture">
			<div class="image">
				<?php $view->ReturnViewPicture(); ?>
			</div>
		</div>
		<div class="main_info">
			<?php $view->returnValue(); ?>
		</div>
	</main>
</body>
</html>
<?php 
} 
else {
	header('Location: login.php');
}
?>