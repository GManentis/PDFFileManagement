<?php
	session_start();
	$x = $_SESSION["user"];
	
	try 
	{
		$CONNPDO = new PDO("sqlite:C:/Users/user/Desktop/dbs/filefolio.db");
		$CONNPDO->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	} 
	catch (PDOException $e) 
	{
		$CONNPDO = null;
	}
	if ($CONNPDO != null)
	{
		$getdata_PRST = $CONNPDO->prepare("SELECT * FROM filefolio_files WHERE uploader = :name ");
		$getdata_PRST->bindValue(":name",$x,SQLITE3_TEXT);
		$getdata_PRST->execute() or die($CONNPDO->errorInfo());
		
		while($getdata_RSLT = $getdata_PRST->fetch(PDO::FETCH_ASSOC,PDO::FETCH_ORI_NEXT))
		{
			$name = $getdata_RSLT["name"];
			unlink("C:/xampp/htdocs/jconnect/files/".$x."/".$name);
		}
		
		rmdir("C:/xampp/htdocs/jconnect/files/".$x);
				
		$getdata_PRST = $CONNPDO->prepare("DELETE FROM filefolio_members WHERE username = :name ");
		$getdata_PRST->bindValue(":name",$x,SQLITE3_TEXT);
		$getdata_PRST->execute() or die($CONNPDO->errorInfo());
		
		$getdata_PRST = $CONNPDO->prepare("DELETE  FROM filefolio_files WHERE uploader = :name ");
		$getdata_PRST->bindValue(":name",$x,SQLITE3_TEXT);
		$getdata_PRST->execute() or die($CONNPDO->errorInfo());
		
		$_SESSION["user"]="";
		session_destroy(); 
        header("location:index.php");
    }
	else
	{
		echo "go back";
	}


?>