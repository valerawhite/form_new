<?php
	require_once('register.php');
	session_start();
	class checkLogin extends MainClass {
		private $email;
		private $password;
		
		public function CheckParameters() {
			$this->email = $this->encode($_POST['name']);
			$this->password = $this->encodePass($_POST['password']);
			if(!empty($this->email) && !empty($this->password)) {
				$data = $this->db->prepare('SELECT * FROM users WHERE password = :password && email = :email');
				$data->execute(array(':password' => $this->password, ':email' =>  $this->email));
				if($data->rowCount() == 1) {
					$row = $data->fetchAll();
					setcookie("id", $row[0]['id'], time()+3600, "/","", 0);
					$_SESSION["id"] = $row[0]['id'];
					
					header('Location: ../profile.php');
				}
				else {
					$str = 'error=true';
					header('Location: ../login.php?' . $str);
				}
			}
			else {
				$str = 'empty=true';
				header('Location: ../login.php?' . $str);
			}
		}
	}
	$obj = new checkLogin();
	$obj->CheckParameters();
?> 