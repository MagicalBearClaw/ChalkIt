<?php
	
	/*
		deletes asticky in the databse with the information 
		obtained from the ajax request.
	*/

	include_once "/Common/Common.php";
	include_once '/Database/autoload.php';
	StartSession();
	$isAuthenticated = IsLoggedIn();

	$config = new MySQLConfig("localhost","chalkit", "root", ""); 

	$StickyNoteDao = new StickyNoteDao($config);


	if(!$isAuthenticated)
	{
		//redirect("index.php", 302);
		$jsonData =  array("msg" => "FAILED");
		echo json_encode($jsonData, JSON_PRETTY_PRINT);
	}
	
	if(isset($_POST['id']) )
	{
		if(is_numeric($_POST['id']))
		{
			$stickyId = htmlentities($_POST['id']);
			$StickyNoteDao->DeleteStickyNote($stickyId);
			$jsonData =  array("msg" => "SUCCESS");
			echo json_encode($jsonData, JSON_PRETTY_PRINT);
		}
	}
?>