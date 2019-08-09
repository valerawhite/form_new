<?php
	require_once('bd.php');
	class MainClass extends bd {
		private $name;
		private $last_name;
		private $email;
		private $phone;
		private $date_n;
		private $password;
		private $fileUp;
		
		private function getParams() {
			$this->name = $this->encode($_POST['name']);
			$this->last_name = $this->encode($_POST['last_name']);
			$this->email = $this->encode($_POST['email']);
			$this->phone = $this->encodeNum($_POST['phone']);
			$this->date_n = $this->encode($_POST['date']);
			$this->password = $this->encodePass($_POST['password']);
			$this->fileUp = $_FILES['file'];
			$values = [
				'name' => $this->name,
				'last_name' => $this->last_name,
				'email' => $this->email,
				'phone' => $this->phone,
				'date_n' => $this->date_n,
				'password' => $this->password,
				'file' => $this->fileUp['name'] 
			];
			$flag = false;
			$str = '';
			foreach($values as $key=>$value) {
				if(empty($value)) {
					$flag = true;
					$str .= $key .'=empty&';
				}
				else {
					$str .= $key .'=' .$value . '&';
				}
			}
			$str .= $this->checkExistUser($str);
			if($flag) {
				header('Location: ../index.php?' . $str);
			} 
			else {
				$new_name = $this->UploadFile($this->fileUp);
				(!$new_name) ? header('Location: ../index.php?' . $str . 'file=error') : $this->fileUp = $new_name;
			}
		}
		public function insetData() {
			$this->getParams();
			unset($str);
			$data = $this->db->prepare('INSERT INTO users (user_name, last_name, email, phone, date, password, picture) VALUES(:fieldName, :fieldLastName, :fieldEmail, :fieldPhone, :fieldDate, :fieldPassword, :fieldPicture)');
			$data->bindParam(':fieldName', $dataName);
			$data->bindParam(':fieldLastName', $dataLast);
			$data->bindParam(':fieldEmail', $dataEmail);
			$data->bindParam(':fieldPhone', $dataPhone);
			$data->bindParam(':fieldDate', $dataDate);
			$data->bindParam(':fieldPassword', $dataPassword);
			$data->bindParam(':fieldPicture', $fieldPicture);
			$dataName = $this->name;
			$dataLast = $this->last_name;
			$dataEmail = $this->email;
			$dataPhone = $this->phone; 
			$dataDate = $this->date_n;
			$dataPassword = $this->password;
			$fieldPicture = $this->fileUp;
			echo ($data->execute()) ?  header('Location: ../login.php?' . $str) : 'Fatal error';
		}
		protected function encode($value) {
			return strip_tags(trim($value));
		}
		protected function encodeNum($value) { 
			if(is_numeric($value)) 
				return $value;
			else 
				return 0;
		}
		protected function encodePass($value) {
			if(!empty($this->encode($value)))
				return md5(trim($value));
		}
		private function UploadFile($file) {
			$type = $file['type'];
			$size = $file['size'];
			if (($type != "image/jpg") && ($type != "image/jpeg") && ($type != "image/png") && ($type != "image/png")) return false;
			if ($size > 1024000) return false;
			$new_name =  $this->generateNamePicture($file['name']);
			$uploadfile = "../images/avatar/". $new_name;
			move_uploaded_file($file['tmp_name'], $uploadfile);
			return $new_name;
		}
		private function generateNamePicture($picture_name) {
			list($small_name, $raz) = explode('.', $picture_name);
			$num = 12;
			$arr = array(
				'a','b','c','d','e','f',
			
				'g','h','i','j','k','l',

				'm','n','o','p','r','s',

				't','u','v','x','y','z',

				'A','B','C','D','E','F',

				'G','H','I','J','K','L',

				'M','N','O','P','R','S',

				'T','U','V','X','Y','Z',

				'1','2','3','4','5','6',

				'7','8','9','0'
			);
			$pass = "";
			for($i = 0; $i < $num; $i++) {
				$index = rand(0, count($arr) - 1);
				$pass .= $arr[$index];
			}
			return $pass . '.' . $raz;	
		}
		private function checkExistUser($str) {
			$data = $this->db->prepare('SELECT * FROM users WHERE  email = :email');
			$data->execute(array(':email' =>  $this->email));
			$str .= 'email_exist=true';
			if($data->rowCount() !== 0)  return $str;
		}
	}
	if(isset($_POST['submit'])) {
		$obj =  new MainClass();
		$obj->insetData();
	}
?>