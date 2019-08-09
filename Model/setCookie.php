<?php
	class setCookieClass {
		public function __construct() {
			if(!empty($_COOKIE['lang'])) {
				if($_COOKIE['lang'] == 'ru') 
					setcookie("lang", "en", time()+3600, "/","", 0);
				else 
					setcookie("lang", "ru", time()+3600, "/","", 0);
			}
			else {
				setcookie("lang", "en", time()+3600, "/","", 0);
			}
		}
	}
	$setCookie = new setCookieClass;
?>