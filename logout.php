<?php
	include_once "/Common/Common.php";
	StartSession();
	$isAuthenticated = IsLoggedIn();

	if($isAuthenticated)
	{
		EndSession();
	}
	else
	{
		redirect("index.php", 302);
	}
?>
