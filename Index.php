<?php

include_once "/Common/Common.php";
include_once '/Database/autoload.php';

	$passError = false;
	$userError = false;
	$userExist = false;

	$config = new MySQLConfig("localhost","chalkit", "root", ""); 

	$userDao = new UserDao($config);
	StartSession();

	$isAuthenticated = IsLoggedIn();

	if($isAuthenticated)
	{
		redirect("userArea.php", 302);
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		// make sure that the crsf token is the same from the post data.
		if(CheckSessionToken($_POST['token']))
		{
			$user = htmlentities($_POST['user']);
			$pass = htmlentities($_POST['pass']);

			$isValidPass = isValidPassword($pass);
			$isValidUser = isValidUserName($user);
			// if not a valid password then allow
			// the display of a password error message.
			if(!$isValidPass)
			{
				$passError = true;
			}
			// if not a valid password then allow
			// the display of a user error message.
			if(!$isValidUser)
			{
				$userError = true;
			}

			if($isValidUser && $isValidPass)
			{
				$newUser = new User($user, $pass);

				$foundUser =  $userDao->FindUserByUserName($user);
				// make sure the username is unique.
				if(!$foundUser)
				{
					$userDao->CreateUser($newUser);
					$id = $userDao->GetUserId($newUser->GetUserName());

					$_SESSION['id'] = $id;
					$isAuthenticated = IsLoggedIn();

					// log us in and redirect us to the user area.
					if($isAuthenticated)
					{
						redirect("userArea.php", 302);
					}
				}
				else
				{
					$userExist = true;
				}
			}

		}
	}
?>

<html>
	<head>
		<title>Chalk it!</title>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

 		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		 <link rel ="stylesheet" href="Css/style.css">
		<meta charset="UTF-8">
	</head>
	<body class = "mainBackground">
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
		     	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		      		<span class="icon-bar"></span>
		      		<span class="icon-bar"></span>
		      		<span class="icon-bar"></span>
		    	</button>
		    	<div class = "nav navbar-left">
		    		<img class = "brandImage-default" alt="Brand" src="Images/brand.png">
		    		<span><a class = "chalk-it navbar-text" href = "index.php">CHALK IT</a></span>
			    </div>
			 </div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">

				<?php
					if(!$isAuthenticated)
					{
						echo "<li><a class = \"chalk-it navbar-text\" href=\"login.php\">Login</a></li>";
			        	echo "<li><a class = \"chalk-it navbar-text\" href=\"index.php\">Register</a></li>";
					}
			    ?>
			    </ul>
			</div>
	    </div>
	</nav>

	<div class="container-fluid-cs">
		<div class = "row-fluid">
		    <div class='centering col-md-4 well background-login'>
		    	<div>
		    		<h2 class = "col-md-offset-3 chalk-it-text">Welcome to Chalk it!</h2>	
		    	</div>
		    	<?php
				if($userError)
				{
				?>
					<div id = "userError" class="alert alert-danger alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <strong>Error!</strong> User name cannot be less than 8 charecters and longer than 16 charecters.
					</div>
				<?php
				}
				?>
				<?php
				if($passError)
				{
				?>
					<div id = "passError" class="alert alert-danger alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <strong>Error!</strong> password needs to be longer than 8 charecters and less than 16 charecters.
					</div>
				<?php
				}
				?>
				<?php
				if($userExist)
				{
				?>
					<div id = "userExist" class="alert alert-danger alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <strong>Error!</strong> User Already Exists.
					</div>
				<?php
				}
				?>

				<form class="form-horizontal" action="" method="POST">
			    <div class="form-group">
			        <label class="col-xs-3 control-label chalk-it-text">Username:</label>
			        <div class="col-xs-8">
			            <input type="text" id = "userNameField" name = "user" class="form-control" title = 'Choose your username'>
			        </div>
			    </div>
			    <div class="form-group">
			        <label class="col-xs-3 control-label chalk-it-text">Password:</label>
			        <div class="col-xs-8">
			            <input type="password" id = "passwordField" name = "pass" class="form-control" title = 'Choose your password'>
			        </div>
			    </div>
				<div class='col-md-offset-5'>
					<input type= "hidden" name = "token" value="<?php echo GenerateSessionToken();?>"></input>
			        <input type="submit" id = "submiteBtn" class="btn btn-primary btn-lg chalk-it-text" value="Register"></input>			
				</div>
				</form>
			</div>
		</div>
	</div>
	<nav class="navbar navbar-fixed-bottom navbar-inverse">
		<p class = "chalk-it-footer navbar-text text-center " style="float:none;">Website (excluding images)  © Michael McMahon, 2015</p>
	</nav>
	</body>
</html>