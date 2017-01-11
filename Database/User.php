
<?php
/*
	This class is responsible to hold all the information that consists of a user.
	Version 1.0
	10/11/2015
*/	
	class User  
	{
		private $m_id;
		private $m_userName;
		private $m_passWord;
		private $m_attemps;
		/*
		 constructs a new user from the username and password
		 provided
		*/
		public function __construct($userName, $password)
		{
			$this->m_userName = $userName;
			$this->m_passWord = $password;
		}
		
		/*
			gets the number of the attemps the user has
			left to login.
		*/
		public function GetAttemps()
		{
			return $this->m_attemps;
		}
		/*
			sets the number of the attemps the user has
			left to login.
		*/
		public function SetAttemps($m_attemps)
		{
			$this->m_attemps = $m_attemps;
		}

		/*
			gets the id of the user.
		*/
		public function GetId()
		{
			return $this->m_id;
		}
		/*
			sets the user id of a user.
		*/
		public function SetId($id)
		{
			$this->m_id = $id;
		}
		/*
			gets the username of a user.
		*/
		public function GetUserName()
		{
			return $this->m_userName;
		}
		/*
			sets the username of a user.
		*/
		public function SetUserName($userName)
		{
			$this->m_userName = $userName;
		}
		/*
			gets the password of a user.
		*/
		public function GetPassword()
		{
			return $this->m_passWord;
		}
		/*
			sets the password of a user.
		*/
		public function SetPassword($passWord)
		{
			$this->m_passWord = $passWord;
		}
	}

?>