<?php
	/*
		updates a sticky based on the infromation
		obtained from the ajax request.
	*/
	include_once "/Common/Common.php";
	include_once '/Database/autoload.php';
	StartSession();

	$config = new MySQLConfig("localhost","chalkit", "root", ""); 

	$StickyNoteDao = new StickyNoteDao($config);

	if(isset($_POST['top']) &&
	   isset($_POST['left'])&& 
	   isset($_POST['id']) )
	{
		if(is_numeric($_POST['top']) && is_numeric($_POST['left']) && is_numeric($_POST['id']))
		{
			$top =  htmlentities($_POST['top']);
			$left =  htmlentities($_POST['left']);
			$stickyId = htmlentities($_POST['id']);
			$StickyNoteDao->UpdateStickyNote($stickyId, $left, $top);
		}
	}
?>