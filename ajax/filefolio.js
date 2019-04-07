$(document).ready(function()
{
	$("#bday").datepicker({changeMonth: true,changeYear: true});
	
	$("#submit").click(function() //edw ksekinaei an ginei click to element me id submit
	{
		var user = $("#usr").val();
		var pass = $("#psd").val();//pairnw ta values
		var mail = $("#mail").val();
		var bday = $("#bday").val();
		var gen  = $("#gender").val();
		
		if(user !='' && pass !='' && mail !='' && bday !='' && gen !='') //an oi sunthikes autes isxuoun (kako policy apla ithela na dw pws kollane vanilla js k query)
		{
			$.ajax(
			{
				type:'POST',
				data:{user:user,pass:pass,mail:mail,bday:bday,gen:gen},
				url:'ajax/SaveUser.php',
				success:function(result)
				{
					$("#response").text(result);
					$(location).attr('href', 'user.php');
					
				}
			});
		}
	});


$.ajax(
	{
		type:'POST',
		data:{},
		url:'ajax/GitFiles.php',
		success:function(result)
		{
			$("#xfiles").html(result);
			
		}
	});

	
	
	
	
	
	
	
	
	
});

function remove(x)
{
	try {				
		var xmlhttp;

		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
			// most browsers
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			// internet explorer
		}
		
				
		xmlhttp.onreadystatechange = function() {			
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var strOut;			
				strOut = xmlhttp.responseText;
				document.getElementById("xfiles").innerHTML = strOut;
			}
		}
		
		xmlhttp.open("POST", "ajax/DeleteFile.php", true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");			
		xmlhttp.send("id="+x);
	}
	catch(err) {
		alert(err);
	}
	
	
	
}



