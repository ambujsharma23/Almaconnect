<?php
include 'patches/variables.php';

if($fpava_setses)
{

	$userid=$_SESSION['userid'];
	$dbcon1=mysqli_connect($fpava_dbip,$fpava_user,$fpava_pass,$fpava_dbname);
	$query1="SELECT postid FROM user_posts ORDER BY postid DESC LIMIT 1";
	$result1=mysqli_query($dbcon1,$query1) or die("query not fired in homefeed sel_up");
	if(mysqli_num_rows($result1)==1)
		{
			$row=mysqli_fetch_array($result1);
			$max=$row['postid'];

			$query2="UPDATE activity_state SET maxpost='$max' Where userid='$userid'";
			mysqli_query($dbcon1,$query2) or die("homefeed_common.php query2");

			include("homefeed_common.php");
		}
	else
		{
			echo "Welcome To Network";
		}
}
else
{
	header('location:http://localhost:8080/connect/index.php');
}
?>
