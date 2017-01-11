<?php
	/*
		creates a new sticky in the databse with the information 
		obtained from the ajax request.
	*/

	include_once "/Common/Common.php";
	include_once '/Database/autoload.php';

	StartSession();
	$isAuthenticated = IsLoggedIn();

	$config = new MySQLConfig("localhost","chalkit", "root", ""); 

	$StickyNoteDao = new StickyNoteDao($config);

	// if we are not authenticated then redirect the user
	// to the index page.
	if(!$isAuthenticated)
	{
		//redirect("index.php", 302);
		$jsonData =  array("msg" => "FAILED");
		echo json_encode($jsonData, JSON_PRETTY_PRINT);
		die();
	}
	
	if(isset($_POST['top']) &&
	   isset($_POST['left'])&& 
	   isset($_POST['text']) )
	{
		if(is_numeric($_POST['top']) && is_numeric($_POST['left']))
		{
			// we have valid data so continue to add the sticky into the db.
			$top =  htmlentities($_POST['top']);
			$left =  htmlentities($_POST['left']);
			if($_SESSION['id'])
				$id =  $_SESSION['id'];
			$text =  htmlentities($_POST['text']);
			if(is_numeric($id))
			{
				$StickyNote = new StickyNote($left, $top, $text, $id);

				$addedId = $StickyNoteDao->CreateStickyNote($StickyNote, $id);
				// sens a message back indicating success.
				$jsonData =  array("msg" => "SUCCESS", "id" => $addedId);
				echo json_encode($jsonData, JSON_PRETTY_PRINT);
			}
		}
	}
?>