<?php
session_start();
if(isset($_SESSION['fullname']) and isset($_SESSION['userid']) and isset($_SESSION['email']))
{
	$userid=$_SESSION['userid'];
	if(isset($_POST['picbtn']))
	{
		define('GW_UPLOADPATH','images/');
		$filename=$_FILES['filename']['name'];
		
		if(!empty($filename))
		{
			$target=GW_UPLOADPATH.$filename;
			if(move_uploaded_file($_FILES['filename']['tmp_name'],$target))
			{
				$dbcon1=mysqli_connect("localhost","root","ambujsharma","almaconnect");
				$query1="UPDATE site_tb SET photo='$filename' WHERE userid='$userid'";
				mysqli_query($dbcon1,$query1);
				header('location:http://localhost:8080/connect/home.php');
			}
		}
	}
}
?>
