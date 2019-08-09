<?php
	require_once('Model/bd.php');
	class View extends bd {
		private $cookieId; 
		private $row;
		private $data;
		public function SelectData() {
			
			$this->cookieId = $_COOKIE['id'];
			$this->data = $this->db->prepare('SELECT user_name, last_name, email, phone, picture, date FROM users WHERE id = :cookieId');
			$this->data->execute(array(':cookieId' => $this->cookieId));
			$this->row = $this->data->fetch(PDO::FETCH_ASSOC);
		}
		public function returnValue() {
			$MESS = $GLOBALS['MESS'];
			if($this->data->rowCount() == 1) {
				echo '<p>' . $this->row['user_name']. ' '. $this->row['last_name'] . '</p>';
				echo '<p>' . $MESS['PROFILE_PHONE'] . $this->row['phone'].  '</p>';
				echo '<p>' . $MESS['PROFILE_EMAIL'] . $this->row['email'].  '</p>';
				echo '<p>' .$MESS['PROFILE_BIRTHDATE'] . $this->row['date'].  '</p>'; 
			}
		}
		public function ReturnViewPicture() {
			echo '<img src="images/avatar/' . $this->row['picture'] . '">';
		}
	}
	$view  = new View();
	$view->SelectData();
?>