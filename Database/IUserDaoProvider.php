
<?php
	interface IUserDaoProvider
	{

		public function CreateUser($user);
		public function FindUserByUserName($userName);
		public function FindUserById($userId); 
		public function GetUserId($userName);
		public function DoesUserExist($userName);
		public function UpdateUserAttemps($attemps, $id);
	}
?>