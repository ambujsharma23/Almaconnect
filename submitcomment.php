<?php
include 'core/template.php';
include 'patches/variables.php';

if($fpava_setses)
{
	$postid=$_POST['postid'];
	$rawcomment=$_POST['commentta'];
	$userid=$_SESSION['userid'];
	$commenterid=$userid;
	$commenter=$_SESSION['fullname'];
	$date=date("d-m-Y-H-i-s");
	$dbcon1=mysqli_connect($fpava_dbip,$fpava_user,$fpava_pass,$fpava_dbname);
	$comment=mysqli_real_escape_string($dbcon1,trim($rawcomment));
	$query1="INSERT INTO comment_tb(postid,userid,comment,time) values('$postid','$userid','$comment','$date')";
	mysqli_query($dbcon1,$query1);

	$query2="SELECT commentid FROM comment_tb WHERE postid='$postid' AND time='$date'";
	$result2=mysqli_query($dbcon1,$query2) or die("submitcomm,ent.php+query2");
	$row2=mysqli_fetch_array($result2);
	$commentid=$row2['commentid'];
	
/*		$query4="SELECT photo FROM site_tb WHERE userid='$userid'";
		$result4=mysqli_query($dbcon1,$query4);
		$row4=mysqli_fetch_array($result4);
		$cimage=fpava_imgpath.$row4['photo'];
*/
		$cname=ucwords($commenter);

		$template->file_register("comments","templates/commentdiv.html");
		$template->var_register("comments","commentid,commenterid,cname,comment");
		$template->file_parse("comments");
		$template->display_page("comments");
}
?>
