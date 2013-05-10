<?php
session_start();
if(isset($_SESSION['userid']) and isset($_SESSION['fullname']) and isset($_SESSION['email']))
{
	$userid=$_SESSION['userid'];
	$dbcon1=mysqli_connect("localhost","root","ambujsharma","almaconnect");
	$query1="SELECT minpost FROM activity_state WHERE userid='$userid'";
	$result1=mysqli_query($dbcon1,$query1) or die("showolderposts.query1");

	if(mysqli_num_rows($result1)==1)
	{
		$row=mysqli_fetch_array($result1);
		$min=$row['minpost'];
		$max=$min;

		if($max>0)
		{		
		require_once("homefeed_common.php");
		}
		else
		{
			echo "No Older Posts";
		}
	}

}
else
{
	header('location:http://192.168.1.4:8080/connect/index.php');
}
?>			
