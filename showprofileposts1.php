<?php
session_start();
if(isset($_SESSION['fullname']) and isset($_SESSION['userid']) and isset($_SESSION['email']))
{
//	$userid=$_SESSION['userid'];
	$id=$_GET['id'];
	require_once("template.php");
	$template=new template;
	
	$dbcon1=mysqli_connect("localhost","root","ambujsharma","almaconnect");
	$query1="SELECT postid FROM user_posts ORDER BY postid DESC LIMIT 1";
	$result1=mysqli_query($dbcon1,$query1) or die("Query not fired..show student posts.php query1");
	if(mysqli_num_rows($result1)==1)
	{
		$row1=mysqli_fetch_array($result1);
		$max=$row1['postid'];
	}

	require_once("showprofileposts2.php");
}
?>
