<!--<html>
<head>
<script type="text/javascript">
function getXmlRequest()
	{
		var xmlhttp=null;
		if(window.XMLHttpRequest)
			{
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}
		else if(window.ActiveXObject)
			{
				// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHttp");
			}
		return xmlhttp;
	}

function addpic()
	{

		xmlhttp=getXmlRequest();

		if(xmlhttp!=null)
			{


				var ele=encodeURIComponent(document.getElementById("filename").name);
				var txt=encodeURIComponent(document.getElementById("filename").value);
				var tosend=ele+"="+txt;
document.write(tosend);
				xmlhttp.open("POST","addpic.php",true);
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.setRequestHeader("Content-length",tosend.length);
				xmlhttp.send(tosend);


				xmlhttp.onreadystatechange=function()
					{

						if(xmlhttp.readyState==4)
							{
								if(xmlhttp.status==200)
									{
										
										var path=xmlhttp.status;
										window.opener.document.getElementById("main").innerHTML=path;
										window.document.close();
										window.close();
								}
							}
				}
			}
	}

</script>
</head>
-->


<html>
<body>
<form name="picform" id="picform" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
<label for="add pic">Add Pic</label>
<input type="file" name="filename" id="filename"/>
<input type="submit" name="picbtn" value="add Pic">
</form>

<?php
$picname=$_FILES['filename']['name'];
if($picname)
{
//echo $picname;
?>
<!--<input type="text" id="hiddenele" value="<?php echo $picname;?>">-->
<script type=text/javascript">
//var ele=window.document.getElementById("hiddenele").value;
alert("ele");
//window.opener.document.getElementById("main").innerHTML=document.getElementById("hiddenele").value;
//window.document.close();
//window.close();
</script>
<?php
}
?>

</body>
</html>
