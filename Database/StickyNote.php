
<?php
/*
	This class is responsible to hold all the information that consists of a sticky.
	Version 1.0
	10/11/2015
*/

	class StickyNote  
	{
		private $m_id;
		private $m_posX;
		private $m_posY;
		private $m_text;
		private $m_userId;

		/*
			constructs a new sticky note.
		*/
		public function __construct($posX, $posY, $text, $userId)
		{
			$this->m_text = $text;
			$this->m_posX = $posX;
			$this->m_posY = $posY;
			$this->m_userId = $userId;
		}
		
		/*
			gets the sticky id.
		*/
		public function GetId()
		{
			return $this->m_id;
		}
		/*
			set the sticky id.
		*/
		public function SetId($id)
		{
			$this->m_id = $id;
		}
		/*
			gets the left position of a sticky.
		*/
		public function GetPosX()
		{
			return $this->m_posX;
		}
		/*
			sets the left position of a sticky.
		*/
		public function SetPosX($posX)
		{
			$this->PosX = $m_posX;
		}
		/*
			gets the top position of a sticky.
		*/
		public function GetPosY()
		{
			return $this->m_posY;
		}
		/*
			sets the top position of a sticky.
		*/
		public function SetPosY($posY)
		{
			$this->m_posY = $posY;
		}
		/*
			gets the text of a sticky.
		*/
		public function GetText()
		{
			return $this->m_text;
		}
		/*
			sets the text of a sticky.
		*/
		public function SetText($text)
		{
			$this->m_text = $text;
		}
		/*
			sets the the user id of a sticky.
		*/
		public function SetUserId($userId)
		{
			$this->m_userId = $userId;
		}
		/*
			get the user id of a sticky.
		*/
		public function GetUserId()
		{
			return $this->m_userId;
		}
	}

?>