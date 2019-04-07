<?php
session_start();

if(isset($_SESSION["user"]) )
{
	$user = $_SESSION["user"];
	
	
	
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
		$getdata_PRST=$CONNPDO->prepare("SELECT * FROM filefolio_members WHERE username = :user");
		$getdata_PRST->bindValue(":user",$user,SQLITE3_TEXT);
		$getdata_PRST->execute() or die($CONNPDO->errorInfo());
		
		while($getdata_RSLT = $getdata_PRST->fetch(PDO::FETCH_ASSOC,PDO::FETCH_ORI_NEXT))
        {
			$name = $getdata_RSLT["username"];
			$bday = $getdata_RSLT["birthday"];
			$birth = strtotime($bday);
			$now = time();
			$temp = ($now - $birth)/(3600*24*30*12);
			$age = floor($temp);
			$gen = $getdata_RSLT["gender"];
			
		}

	}
	else
	{
		$response = "";
	}
	
}
else
{
	header('Location:index.php');
	
}

if(isset($_POST["logout"]))
{
		$_SESSION["user"] = "";
		session_destroy();
		header('location:index.php');
}

?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $_SESSION["user"]."'s Profile!" ?></title>
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
	<div class="container">
	<center>
	<h3 style="color:red;">Welcome,<?php echo $_SESSION["user"]; ?><h3>
	</center>
	<hr>
	<span style="float:right;"><form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>"><input type="submit" name="logout" value="Log Out" class="btn btn-default"></form></span>
	</div>
	<div class="container">
		<span style="float:left;width:160px;height:300px;border:2px solid red;word-wrap:break-word;padding:10px;margin:20px;">
			<center><b><?php echo $_SESSION["user"]; ?></b></center>
			<br>
			Birthdate:<?php echo $bday;?> (<?php echo $age; ?>)
			<br>
			Gender:<?php echo $gen; ?>
			<hr>
			<center><b>Actions</b></center>
			<br>
			<a href="upload.php">Upload File</a>
			<br>
			<a href="delete.php">Delete account</a>
			<br><br>
			<a href="info.php">More Info</a>
		</span>
		<span id="xfiles" style="float:left;width:800px;height:450px;border:2px solid red;word-wrap:break-word;padding:10px;margin:20px;"></span>
	</div>
</body>
</html>