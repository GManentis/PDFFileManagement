<?php
session_start();

if(isset($_SESSION["user"]))
{
	header('Location:user.php ');
}

if(isset($_POST["submit"]))
{
	if(isset($_POST["user"]) && isset($_POST["pass"]))
	{
		$user = $_POST["user"];
		$pass = $_POST["pass"];
	
		try
		{
			$CONNPDO = new PDO("sqlite:C:/Users/user/Desktop/dbs/filefolio.db");
			$CONNPDO->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)
		{
			$CONNPDO = null;
		}
	
		if($CONNPDO != null)
		{
			$user = $_POST["user"];
			$pass = $_POST["pass"];
		
			$getdata_PRST=$CONNPDO->prepare("SELECT COUNT(id) AS number FROM  filefolio_members WHERE username = :user");
			$getdata_PRST->bindValue(":user",$user,SQLITE3_TEXT);
			$getdata_PRST->execute() or die($CONNPDO->errorInfo());
				
				while($getdata_RSLT = $getdata_PRST->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT))
				{
					$num = $getdata_RSLT["number"];
				}
				
				if($num != 0)
				{
					$getdata_PRST=$CONNPDO->prepare("SELECT password FROM  filefolio_members WHERE username = :user");
					$getdata_PRST->bindValue(":user",$user,SQLITE3_TEXT);
					$getdata_PRST->execute() or die($CONNPDO->errorInfo());
					
					while($getdata_RSLT = $getdata_PRST->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT))
					{
						$check = $getdata_RSLT["password"];
					}
					
					if(password_verify($pass,$check))
					{
						$_SESSION["user"] = $user;
						header('Location:user.php ');
					}
					else
					{
						$response = "Username and/or password is incorrect";
					}
				}
				else
				{
					$response = "Wrong Credentials!";
				
				}
		}
		else
		{
			$response = "No db connection";
		}

	}
	else
	{
		$response = "Please insert legit credentials";
	}

}
else
{
	$response = "";
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Log In!</title>
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
	<h3 style="color:red;">Log In!</h3>
	<hr>
	<div class="container">
	<form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>" >
	<table>
	<tr><td>Usrname:</td><td><input class="form-control" type="text" name="user"></td></tr>
	<tr><td>Password:</td><td><input class="form-control" type="password" name="pass"></td></tr>
	<tr><td>&nbsp;&nbsp;</td><td><br><input type="submit" name="submit" value="Submit!"></td></tr>
	</table>
	</form>
	<hr>
	<span><?php echo $response;?></span>
	</div>
</center>
</body>
</html>