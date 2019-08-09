<?php 
if(empty($_COOKIE['lang'])) setcookie("lang","ru", time()+3600, "/","", 0);
	if(@$_COOKIE['lang'] == 'ru') {
		require_once('lang/ru/index.php');
	}
	else {
		require_once('lang/en/index.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>Форма регистрации</title>
<link href="css/main.css?1" rel="stylesheet">
<script src="scripts/lang.js"></script>

</head>
<body>
	<?php include('header.php');?>
	<main>
		<div class="wrap_form">
			<p class="exist_user"><?php if(isset($_GET['email_exist']) && $_GET['email_exist'] == 'true') echo ' Такой пользователь уже существует ' .$_GET['email'];?></p>
			<form action="Model/register.php" method="POST" enctype="multipart/form-data">
				<div class="outer"><input type="text" value="<?php if(isset($_GET['name']) && $_GET['name'] !== 'empty') echo $_GET['name'];?>" id="name" name="name" placeholder="<?php echo $MESS['INPUT_NAME']; ?>"><?php if(isset($_GET['name']) && $_GET['name'] == 'empty') echo '<span class="error">' .$MESS['EMPTY_VALUE'].'</span>';?></div>
				<div class="outer"><input type="text" value="<?php if(isset($_GET['last_name']) && $_GET['last_name'] !== 'empty') echo $_GET['last_name'];?>" name="last_name" id="last_name" placeholder="<?php echo $MESS['INPUT_LAST_NAME']; ?>"><?php if(isset($_GET['last_name']) && $_GET['last_name'] == 'empty') { echo '<span class="error">' .$MESS['EMPTY_VALUE'].'</span>';}?></div>
				<div class="outer"><input type="email" value="<?php if(isset($_GET['email']) && $_GET['email'] !== 'empty') echo $_GET['email'];?>"  id="email" name="email" placeholder="<?php echo $MESS['INPUT_EMAIL']; ?>"><?php if(isset($_GET['email']) && $_GET['email'] == 'empty') echo '<span class="error">' .$MESS['EMPTY_VALUE'].'</span>';?></div>
				<div class="outer"><input type="tel" value="<?php if(isset($_GET['phone']) && $_GET['phone'] !== 'empty') echo $_GET['phone'];?>" id="phone" name="phone" placeholder="<?php echo $MESS['INPUT_PHONE']; ?>"><?php if(isset($_GET['phone']) && $_GET['phone'] == 'empty') echo '<span class="error">' .$MESS['EMPTY_VALUE'].'</span>';?></div>
				<div class="outer wrap_date"><input type="date" value="<?php if(isset($_GET['date_n']) && $_GET['date_n'] !== 'empty') echo $_GET['date_n'];?>" id="date" name="date" value="asd"><?php if(isset($_GET['date_n']) && $_GET['date_n'] == 'empty') echo '<span class="error">' .$MESS['EMPTY_VALUE'].'</span>';?></div>
				<div class="outer"><input type="password" id="password" name="password" placeholder="<?php echo $MESS['INPUT_PASSWORD']; ?>"><?php if(isset($_GET['password']) && $_GET['password'] == 'empty') echo '<span class="error">' .$MESS['EMPTY_VALUE'].'</span>';?></div>
				<div class="outer"><input class="input" id="uploadInput" name="file" type="file"><?php if(isset($_GET['file']) && $_GET['file'] == 'error') { echo '<span class="error">'  .$MESS['INCORRECT_VALUE'].'</span>'; } elseif(isset($_GET['file']) && $_GET['file'] == 'empty') { echo '<span class="error">'  .$MESS['EMPTY_VALUE'].'</span>'; }?></div>
				<input type="submit" name="submit" id="submit" value="<?php echo $MESS['SEND']; ?>">
			</form>
			<div class="autorization">
				<a href="login.php"><?php echo $MESS['AUTORIZATION']; ?></a>
			</div>
		</div>
	</main>
<script>
	window.onload = function () {
		var submit = document.getElementById('submit');
		submit.onclick = function() {
			var elements = [
					document.getElementById('name'),
					document.getElementById('last_name'),
					document.getElementById('email'),
					document.getElementById('phone'),
					document.getElementById('date'),
					document.getElementById('password'),
					document.getElementById('uploadInput')
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
					if(i == 2) {
						validMail(elements[i], elements[i].value);
					}
					else if(i == 3) {
						validPhone(elements[i], elements[i].value);
					}
					else if(i == 6) {
						updateSize(elements[i]);
					}
				}
			}
		}
		function validMail(el, value) {
			var preg = /^[\w-\.]+@[\w-]+\.[a-z]{2,4}$/i;
			var valid = preg.test(value);
			if (valid) 
				return true;
			else 
				if (!el.classList.contains("not-valid")) {
					el.classList.add("not-valid");
					span = createElementSpan('<?php echo $MESS['INCORRECT_EMAIL'];?>');
					el.after(span);
				}
		}
		function validPhone(el, value) {
			var preg = /^\d[\d\(\)\ -]{4,14}\d$/;
			var valid = preg.test(value);
			if (valid) 
				return true;
			else 
				if (!el.classList.contains("not-valid")) {
					el.classList.add("not-valid");
					span = createElementSpan('<?php echo $MESS['INCORRECT_PHONE'];?>');
					el.after(span);
				}
		}
	}
	function updateSize(fileEl) {
		var file = fileEl.files[0],
		ext = "не определилось",
		parts = file.name.split('.'); 
		if (parts.length > 1) ext = parts.pop();
		alert(ext);
		if(ext != 'jpg' && ext != 'png' && ext != 'gif') {
			if (!fileEl.classList.contains("not-valid")) {
				fileEl.classList.add("not-valid");
				span = createElementSpan('<?php echo $MESS['INCORRECT_TYPE_FILE'];?>');
				fileEl.after(span);
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