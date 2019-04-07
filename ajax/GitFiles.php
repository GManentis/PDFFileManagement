<?php
session_start();

if(isset($_SESSION["user"]))
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
		$response = "<table class='table'><tr><th>Name</th><th>Type</th><th>Size</th><th>&nbsp;&nbsp;</th></tr>";
		
		$getdata_PRST = $CONNPDO->prepare("SELECT * FROM filefolio_files WHERE uploader = :user");
		$getdata_PRST->bindValue(":user",$user,SQLITE3_TEXT);
		$getdata_PRST->execute() or die($CONNPDO->errorInfo());
		
		while($getdata_RSLT = $getdata_PRST -> fetch(PDO::FETCH_ASSOC,PDO::FETCH_ORI_NEXT))
		{
			$filename = $getdata_RSLT["name"];
			$size_temp = $getdata_RSLT["filesize"];
			$size = round($size_temp/(1024*1024),2);
			$type_temp = explode("/",$getdata_RSLT["type"]);
			$type = $type_temp[1];
			$id = $getdata_RSLT["id"];
			
			$response .= "<tr><td><a href=\"http://localhost/jconnect/files/$user/$filename\">$filename</a>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;$type&nbsp;&nbsp;</td><td>&nbsp;&nbsp;$size MB&nbsp;&nbsp;</td><td><button onclick='remove($id)'>Remove</button></td></tr>";	
		}
		
		$response .= "</table>";
		
		echo $response;
	}
	else
	{
		echo "no db connection :'( ";
	}

}
else
{
	echo "ERROR!";
}


?>