<?php
session_start();
	
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
		
		$getdata_PRST=$CONNPDO->prepare("SELECT * FROM  filefolio_members WHERE username = :user");
		$getdata_PRST->bindValue(":user",$user,SQLITE3_TEXT);
		$getdata_PRST->execute() or die($CONNPDO->errorInfo());
		$count = $getdata_PRST ->rowCount();
		
		if($count != 0)
		{	
			while($getdata_RSLT = $getdata_PRST->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT))
			{
				$check = $getdata_RSLT["password"];
			}
			
			if(password_verify($pass, $check))
			{
				$_SESSION["user"] = $user;
				echo "Welcome aboard!";
				header('location:user.php');
			}
			else
			{
				echo $count;
			}
		}
		else
		{
			echo "" ;
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