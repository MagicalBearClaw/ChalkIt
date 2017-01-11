<?php
/*
 	The purpose of this file is to hold common functionality
 	that is used throughout the site.

 	Micahel McMahon
 	11/2/2015
*/

define('MAX_SESSION_TIME', '0'); 

/*
	This function redirects the user to
	an other page.
*/
function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}
define('TOKEN_LENGHT', '32');

/*
	This function is used to start a session.
*/
function StartSession()
{

	session_start();
	session_set_cookie_params(MAX_SESSION_TIME,"/","",false, true);
 	session_regenerate_id(true);
}

/*
	This function is used to generate a unique
	token to prevent crsf attacks.
*/
function GenerateSessionToken()
{
	return $_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
}

/*
	This function is used to determine if the passed in
	token is the same as the generated one in the
	$_session variable.
*/
function CheckSessionToken($token)
{
	if(isset($_SESSION['token']) && $token === $_SESSION['token'])
	{
		unset($_SESSION['token']);
		return true;
	} 
	else
		return false; 
}

/*
	This function is used to end a session.
	also clears client cookies.
*/
function EndSession()
{
    session_start();
	$_SESSION = array();
 
	$params = session_get_cookie_params();
	 
	setcookie(session_name(),
	        '', time() - 42000, 
	        $params["path"], 
	        $params["domain"], 
	        $params["secure"], 
	        $params["httponly"]);
	 
	session_destroy();

	redirect("index.php",302);
}
/*
	This function is used to determine if a
	user is logged in or not.
*/
function IsLoggedIn()
{
	if (isset($_SESSION['id'])) 
	{
		return true;
    }
    return false;
}
/*
	This function is used to do minimum validation on
	a user password.
*/
function isValidPassword($pass)
{
	if(!isset($pass) && !empty($pass))
	{
		return false;
	}

	$passLenght = strlen($pass);
	if($passLenght >= 6 && $passLenght <= 16)
	{
		return true;
	}
	else
		return false;
}
/*
	This function is used to do minimal validation
	for a username.
*/
function isValidUserName($userName)
{

	if(!isset($userName) && !empty($userName))
	{
		return false;
	}

	$userNameLenght = strlen($userName);
	if($userNameLenght >= 6 && $userNameLenght < 16)
	{
		return true;
	}
	else
		return false;
}


?>

