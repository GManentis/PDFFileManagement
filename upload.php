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
		if(isset($_POST["submit"]))
		{
			if(isset($_FILES["file"]["name"]))
			{
				$target_dir = "C:/xampp/htdocs/jconnect/files/".$_SESSION["user"]."/";
				$target_file = $target_dir . basename($_FILES["file"]["name"]);
				$Name = $_FILES["file"]["name"];
				$type = $_FILES["file"]["type"];
				$data= file_get_contents($_FILES["file"]['tmp_name']);
				$hash = md5($data);
				$filesize =  $_FILES["file"]["size"];
				
				$getdata_PRST = $CONNPDO->prepare("SELECT * FROM filefolio_files WHERE name = :name AND uploader = :uploader ");
				$getdata_PRST -> bindValue(":name",$Name,SQLITE3_TEXT);
				$getdata_PRST -> bindValue(":uploader",$user,SQLITE3_TEXT);
				$getdata_PRST->execute() or die($CONNPDO->errorInfo());
				$count = $getdata_PRST->rowCount();
				
				if($count != 0)
				{   
					$Name2 = $Name.($count + 1);
					$getdata_PRST = $CONNPDO->prepare("SELECT * FROM filefolio_files WHERE hash = :hash AND uploader = :uploader ");
					$getdata_PRST -> bindValue(":hash",$hash,SQLITE3_TEXT);
					$getdata_PRST -> bindValue(":uploader",$user,SQLITE3_TEXT);
					$getdata_PRST->execute() or die($CONNPDO->errorInfo());
					$count2 = $getdata_PRST->rowCount();
					
					if($count2 == 0)
					{
						$adddata_PRST = $CONNPDO->prepare("INSERT INTO filefolio_files(name, type, filesize,  uploader, hash) VALUES (:name, :type, :filesize,  :uploader, :hash) ");
						$adddata_PRST -> bindValue(":name",$Name2,SQLITE3_TEXT);
						$adddata_PRST -> bindValue(":type",$type,SQLITE3_TEXT);
						$adddata_PRST -> bindValue(":filesize",$filesize,SQLITE3_TEXT);
						$adddata_PRST -> bindValue(":uploader",$user,SQLITE3_TEXT);
						$adddata_PRST -> bindValue(":hash",$hash,SQLITE3_TEXT);
						$adddata_PRST -> execute() or die($CONNPDO->errorInfo());
						
						move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
						
						$response = "Your file has been successfully uploaded!<a href='user.php'>Go Back!</a>";
						
					}
					else
					{
						$response = "File already exists,please upload other file or!<a href='user.php'>go Back!</a>";
					}
				
				}
				else
				{
					$adddata_PRST = $CONNPDO->prepare("INSERT INTO filefolio_files(name, type, filesize,  uploader, hash) VALUES (:name, :type, :filesize,  :uploader, :hash) ");
					$adddata_PRST -> bindValue(":name",$Name,SQLITE3_TEXT);
					$adddata_PRST -> bindValue(":type",$type,SQLITE3_TEXT);
					$adddata_PRST -> bindValue(":filesize",$filesize,SQLITE3_TEXT);
					$adddata_PRST -> bindValue(":uploader",$user,SQLITE3_TEXT);
					$adddata_PRST -> bindValue(":hash",$hash,SQLITE3_TEXT);
					$adddata_PRST -> execute() or die($CONNPDO->errorInfo());
					
					move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
					$response = "Your file has been successfully uploaded!<a href='user.php'>Go Back!</a>";
				
				}
			}
			else
			{
				$response = "Please select file to upload";
			}
		}
		else
		{
			$response = "";
		}

	}
	else
	{
		$response = "no connection";
	}
	
}
else
{
	header('Location:index.php');
	$name = "";
	$response = "";
	
	
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Upload file - <?php echo $_SESSION["user"]; ?></title>
	<meta charset="UTF-8">
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
	<br>
	<center>
	<h3 style="color:red">Upload Your File</h3>
	</center>
	<hr>
	<br>
	<div class="container">
	<center>
	<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
	<input type="file" name="file" id="file" accept="application/pdf">
	<br>
	<input type="submit" name="submit" value="Upload File!" class="btn btn-success">
	</form>
</center>
<hr>
<center>
<div class="container">
<br>
<?php echo $response; ?>
<br><br>
<hr>
Nothing to upload??<a href="user.php">Go back</a>&nbsp;anytime you want :)
</div>
</center>
</body>
</html>