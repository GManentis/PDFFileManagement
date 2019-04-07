<?php
session_start();
	
if(isset($_POST["user"]) && isset($_POST["pass"]) && isset($_POST["mail"]) && isset($_POST["bday"]) && isset($_POST["gen"]) )
{
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
		$mail = $_POST["mail"];
		$bday = $_POST["bday"];
		$gender = $_POST["gen"];
		
		$password = password_hash($pass,PASSWORD_DEFAULT);
		
		$getdata_PRST=$CONNPDO->prepare("SELECT * FROM filefolio_members WHERE username = :user OR email = :mail");
		$getdata_PRST->bindValue(":user",$user, SQLITE3_TEXT);
		$getdata_PRST->bindValue(":mail",$mail, SQLITE3_TEXT);
		$getdata_PRST->execute() or die($CONNPDO->errorInfo());
		$count = $getdata_PRST->rowCount();
		
		if($count == 0)
		{
			$adddata_PRST = $CONNPDO->prepare("INSERT INTO filefolio_members(username, password, email, birthday, gender) VALUES (:user, :pass, :mail, :bday, :gen) ");
			$adddata_PRST->bindValue(":user",$user, SQLITE3_TEXT);
			$adddata_PRST->bindValue(":pass",$password, SQLITE3_TEXT);
			$adddata_PRST->bindValue(":mail",$mail, SQLITE3_TEXT);
			$adddata_PRST->bindValue(":bday",$bday);
			$adddata_PRST->bindValue(":gen",$gender, SQLITE3_TEXT);
			$adddata_PRST->execute() or die($CONNPDO->errorInfo());
			
			$dir = "C:/xampp/htdocs/jconnect/files/".$user;
			mkdir($dir);
			
			
			$_SESSION["user"] = $user;
			echo "Credentials have been successfully saved,Please go to SignUp now";
		}
	}
	else
	{
		echo "No db connection";
	}

}
else
{
	echo "Please insert legit credentials";
}

?>