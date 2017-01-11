<?php

/*
	This class is responsible for the data access object 
	for the user.
	Version 1.0
	10/11/2015
*/
	include_once '/Database/IUserDaoProvider.php';
	include_once '/Database/autoload.php';

	class UserDao implements IUserDaoProvider
	{
		
		private $m_pdo;
		/*
		 * Constructs a new user data access object.
		 * used to access the database.
		*/
		public function __construct($config)
		{
			if(!isset($config))
				throw new InvalidArgumentException("config cannot be null");
			$this->m_pdo =  new PDO("mysql:host=". $config->GetHostName() . ";" . "dbname=" . $config->GetdbName() .";",$config->GetUserName(),$config->GetPassword());
		}

		// creates a new user from the user bean.
		public function CreateUser($User)
		{
			if(!isset($User))
				throw new InvalidArgumentException("User can not be null");		
			try
			{
				$hasedPassword =  password_hash($User->GetPassword(), PASSWORD_DEFAULT);
				$query =  $this->m_pdo->prepare("INSERT INTO user (userName,password) VALUES(:userName,:password);");
				$query->bindValue(':userName',$User->GetUserName());
				$query->bindValue(':password', $hasedPassword);
				$query->execute();
			}
			catch(PDOException $ex)
			{
				//echo $ex->getMessage();
			}
		}

		// determines if the username is already in use.
		public function DoesUserExist($userName)
		{
			if(!isset($userName))
				throw new InvalidArgumentException("userName can not be null");		
			$found = null;
			try
			{
				$query =  $this->m_pdo->prepare("SELECT id, userName, password FROM user where userName = :userName");
				$query->bindValue(':userName',$userName);
				$query->execute();
				$result = $query->fetch();

				if($result != null)
				{
					$found = true;
				}

			}
			catch(PDOException $ex)
			{
				//echo $ex->getMessage();
			}
			return $found;
		}
		//finds a user in the databse matching the given username.
		public function FindUserByUserName($userName)
		{
			if(!isset($userName))
				throw new InvalidArgumentException("userName can not be null");		
			$user = null;
			try
			{
				$query =  $this->m_pdo->prepare("SELECT id, userName, password, attemps FROM user where userName = :userName");
				$query->bindValue(':userName',$userName);
				$query->execute();
				$result = $query->fetch();

				if($result != null)
				{
					$user =  new User($result['userName'], $result['password']);
					$user->SetId($result['id']);
					$user->SetAttemps($result['attemps']);
				}

			}
			catch(PDOException $ex)
			{
				//echo $ex->getMessage();
			}
			return $user;
		}
		// updates the number of attemps a suer had to login given
		// the attemps and user id provided.
		public function UpdateUserAttemps($attemps, $id)
		{
			if(!isset($attemps) || !isset($id))
				throw new InvalidArgumentException("atemps and id cannot be empty or null");		
			$user = null;
			try
			{
				$query =  $this->m_pdo->prepare("UPDATE user SET attemps = :attemps WHERE id = :id;");
				$query->bindValue(':attemps',$attemps);
				$query->bindValue(':id',$id);
				$query->execute();
			}
			catch(PDOException $ex)
			{
				//echo $ex->getMessage();
			}
			return $user;
		}

		// finds a user by its user id.
		public function FindUserById($userId)
		{
			if(!isset($userId))
				throw new InvalidArgumentException("userId can not be null");		
			$user = null;
			try
			{
				$query =  $this->m_pdo->prepare("SELECT id, userName, password, attemps FROM user where id = :id");
				$query->bindValue(':id',$userId, PDO::PARAM_INT);
				$query->execute();
				$result = $query->fetch();

				$user = new User($result['userName'],$result['password'] );
				$user->setId($result['id']);
				$user->SetAttemps($result['attemps']);
			}
			catch(PDOException $ex)
			{
				//echo $ex->getMessage();
			}
			return $user;
		}
		// gets the user id of a user.
		public function GetUserId($userName)
		{
			if(!isset($userName))
				throw new InvalidArgumentException("userName can not be null");		
			$userId = null;
			try
			{
				$query =  $this->m_pdo->prepare("SELECT id FROM user where userName = :userName;");
				$query->bindValue(':userName',$userName);
				$query->execute();
				$result = $query->fetch();

				$userId = $result['id'];
			}
			catch(PDOException $ex)
			{
				//echo $ex->getMessage();
			}
			return $userId;
		}
	}

?>