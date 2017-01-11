<?php

	include_once '/Database/IStickyNoteDaoProvider.php';
	include_once '/Database/autoload.php';

/*
	this is the database access object for sticky notes.

	Michael McMahon
	11/12/2015
*/

	class StickyNoteDao implements IStickyNoteDaoProvider
	{
		
		private $m_pdo;
		/*
			constructs a new sticky dao object
		*/
		public function __construct($config)
		{
			if(!isset($config))
				throw new InvalidArgumentException("config cannot be null");
			$this->m_pdo = new PDO("mysql:host=". $config->GetHostName() . ";" . "dbname=" . $config->GetdbName() .";",$config->GetUserName(),$config->GetPassword());
		}

		// Creates a new sticky note with the provided sticky and userid
		public function CreateStickyNote(StickyNote $sticky, $userId)
		{
			if(!isset($sticky))
				throw new InvalidArgumentException("stickyNote can not be null");
			if(!isset($sticky))
				throw new InvalidArgumentException("userId can not be null");			
			
			$insertId =  null;
			try
			{
				
				$query =  $this->m_pdo->prepare("INSERT INTO sticky_note (pos_x,pos_y,text,user_id) VALUES(:pos_x,:pos_y,:text,:userId);");
				$query->bindValue(':pos_x',$sticky->GetPosX());
				$query->bindValue(':pos_y', $sticky->GetPosY());
				$query->bindValue(':text', $sticky->GetText());
				$query->bindValue(':userId', $userId);
				$query->execute();
				// get the id of the sticky that was just added.
				$insertId = $this->m_pdo->lastInsertId();
			}
			catch(PDOException $ex)
			{
				//echo $ex->getMessage();
			}
			return $insertId;
		}
		// deletes a sticky given its id.
		public function DeleteStickyNote($id)
		{
			if(!isset($id))
				throw new InvalidArgumentException("id can not be null");
			try
			{
				$query =  $this->m_pdo->prepare("DELETE FROM sticky_note WHERE id = :id");
				$query->bindValue(':id', $id);
				$query->execute();
			}
			catch(PDOException $ex)
			{
				//echo $ex->getMessage();
			}
		}
		// get all stickies for a given user id
		public function GetAllStickyNotesForUser($userId)
		{
			if(!isset($userId))
				throw new InvalidArgumentException("id can not be null");
			$stickyArray = [];
			try
			{
				
				$query =  $this->m_pdo->prepare("SELECT * FROM sticky_note WHERE user_id = :id");
				$query->bindValue(':id', $userId);
				$query->execute();

				// store the retrieved data into sticky bean.
				while ($result = $query->fetch()) 
				{
					$sticky =  new StickyNote($result['pos_x'], $result['pos_y'], $result['text'], $result['user_id']);
					$sticky->setId($result['id']);
					$stickyArray[] = $sticky;
				}		
			}
			catch(PDOException $ex)
			{
				//echo $ex->getMessage();
			}
			return $stickyArray;
		}
		
		// update a sticky based on its id, left and top positiion.
		public function UpdateStickyNote($id, $posX, $posY)
		{
			if(!isset($id))
				throw new InvalidArgumentException("id can not be null");
			$isUpdated = false;
			try
			{	
				$query =  $this->m_pdo->prepare("UPDATE sticky_note SET pos_x = :posX, pos_y = :posY WHERE id = :id;");
				$query->bindValue(':id', $id);
				$query->bindValue(':posX', $posX);
				$query->bindValue(':posY', $posY);								
				$query->execute();
				
				$isUpdated = true;						
			}
			catch(PDOException $ex)
			{
				//echo $ex->getMessage();
			}
			return $isUpdated;
		}

	}

?>