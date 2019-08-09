	function setLang() {
		var xhr = new XMLHttpRequest();
		xhr.open('GET', 'Model/setCookie.php', true);
		xhr.send();
		xhr.onreadystatechange = function() {
		if (this.readyState != 4) return;
			if (this.status != 200) {
				alert( 'ошибка установки языка' );
				return;
			}
			else {
				location.reload();
			}
		}
	}
