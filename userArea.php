<?php
	include_once "/Common/Common.php";
	StartSession();
	$isAuthenticated = IsLoggedIn();

	if(!$isAuthenticated)
	{
		redirect("index.php", 302);
	}
?>
<html>
	<head>
		<title>Chalk It</title>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
 		<script src="Js/postArea.js"></script>

 		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="Js/postArea.js"></script>
		<link rel ="stylesheet" href="Css/style.css">
		<meta charset="UTF-8">
	</head>
	<body class = "application">
		<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
		     	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		      		<span class="icon-bar"></span>
		      		<span class="icon-bar"></span>
		      		<span class="icon-bar"></span>
		    	</button>
		    	<div class = "nav navbar-left">
		    			<img class = "brandImage" alt="Brand" src="Images/brand.png">
						<span><a class = "chalk-it navbar-text" href = "index.php">CHALK IT</a></span>
		    			<?php
							if($isAuthenticated)
							{
								echo "<input type=\"button\" id = \"createBtn\"class = \"create-button\" name=\"createSticky\">";
							}
				    	?>
			    </div>
			 </div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
				<?php
					if($isAuthenticated)
					{
						echo "<li><a class = \"chalk-it navbar-text\" href=\"logout.php\"> Logout</a></li>";
					}
			    ?>
			    </ul>
			</div>
	    </div>
	</nav>
	<div id="dialog-form" class = "hide" title="Create new sticky note">
	<form id = "createStickyForm">
		<div id = "textError" class="hide alert alert-danger alert-dismissible" role="alert">
		  <button id = "errorBtn" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  <strong>Error!</strong> The text cannot be empty or be greater than 280 charecters.
		</div>
		<fieldset class = "modal-field-set">
			<label class = "modal-input" for="createSticky">Note</label>
			<textarea rows = "5" cols = "35" name="createSticky" id="createSticky" class="text ui-widget-content ui-corner-all"></textarea> 
			<input type="submit" tabindex="-1" style="position:absolute; top:-500px">
		</fieldset>
	</form>
	</div>
	<div id="postIt-container" class = "postIt-board">
	</div>
	<nav class="navbar navbar-fixed-bottom navbar-inverse">
		<p class = "chalk-it-footer navbar-text text-center " style="float:none;">Website ( excluding images )  © Michael McMahon, 2015</p>
	</nav>
	</body>
</html>