<?php
session_start();

if(isset($_SESSION["user"]))
{
	header('Location:user.php ');
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign Up Today!</title>
	<meta charset="UTF8">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="ajax/filefolio.js"></script>
</head>
<body>
<center>
	<h3 style="color:red;">Create your account today and store your files!</h3>
	<hr>
	<div class="container">
	<table>
	<tr><td>Usrname:</td><td><input class="form-control" type="text" id="usr"></td></tr>
	<tr><td>Password:</td><td><input class="form-control" type="password" id="psd"></td></tr>
	<tr><td>Email:</td><td><input class="form-control" type="email" id="mail"></td></tr>
	<tr><td>Birthdate:</td><td><input class="form-control" type="text" id="bday"></td></tr>
	<tr><td>Gender:</td><td><input type="radio" name="gender" id="gender" value="Male">&nbsp;Male&nbsp;&nbsp;<input type="radio" name="gender" id="gender" value="Female">&nbsp;Female</td></tr>
	<tr><td>&nbsp;&nbsp;</td><td><br><button class="btn btn-primary" id="submit">Submit!</button></td></tr>
	</table>
	<hr>
	<span id="response"></span>
	</div>
</center>
</body>
</html>