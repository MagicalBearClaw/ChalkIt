
<?php
	interface IStickyNoteDaoProvider
	{
		public function CreateStickyNote(StickyNote $sticky, $userId);
		public function DeleteStickyNote($id);
		public function GetAllStickyNotesForUser($userId);
		public function UpdateStickyNote($id, $posX, $posY);
	}
?>