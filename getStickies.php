<?php

	/*
		gets all the stickies in the databse and returns them as a 
		json response.
	*/
	include_once "/Common/Common.php";
	include_once '/Database/autoload.php';
	StartSession();


	$config = new MySQLConfig("localhost","chalkit", "root", ""); 

	$StickyNoteDao = new StickyNoteDao($config);

	$id =  $_SESSION['id'];
	if(is_numeric($id))
	{
		$id =  htmlentities($id);
		$stickies = $StickyNoteDao->GetAllStickyNotesForUser($id);
		foreach ($stickies as $key => $sticky) 
		{
			$elements[] = array("left" => $sticky->GetPosX(),
								 "top" => $sticky->GetPosY(),
								 "text" => $sticky->GetText(),
								 "id" => $sticky->GetId());

		}
		$jsonArray = array("msg" => "SUCCESS","stickies" => $elements);
		echo json_encode($jsonArray, JSON_PRETTY_PRINT);
	}
?>