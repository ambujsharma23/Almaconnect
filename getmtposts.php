<?php
include 'core/template.php';
include 'patches/variables.php';

if($fpava_setses)
{
	$userid=$_SESSION['userid'];
	$dbcon1=mysqli_connect($fpava_dbip,$fpava_user,$fpava_pass,$fpava_dbname);
	$query1="SELECT postid FROM user_posts ORDER BY postid DESC LIMIT 1";
	$result1=mysqli_query($dbcon1,$query1) or die("Query not fired..show student posts.php query1");
	if(mysqli_num_rows($result1)==1)
	{
		$row1=mysqli_fetch_array($result1);
		$max=$row1['postid'];
	}

$membertype=$_GET['mtype'];
$count=0;
$query4="SELECT user_posts.postid,user_posts.userid, user_posts.poster_name, user_posts.posts, user_posts.time FROM user_posts,site_tb WHERE user_posts.postid<='$max' AND user_posts.userid=site_tb.userid AND site_tb.site_mt='$membertype' ORDER BY user_posts.postid DESC";
	
$result4=mysqli_query($dbcon1,$query4) or die("query not fired at showstudentposts.php query4");
	if(mysqli_num_rows($result4))
	{
		while($row=mysqli_fetch_array($result4) and $count<20)
		{
			$poster_name=strtoupper($row['poster_name']);
			$post=$row['posts'];
			$min=$row['postid'];
			$posterid=$row['userid'];
			$query5="SELECT photo FROM site_tb WHERE userid='$posterid'";
			$result5=mysqli_query($dbcon1,$query5);
			$row5=mysqli_fetch_array($result5);
			$uimgsrc=fpava_imgpath.$row5['photo'];

			$ufname=$poster_name;
			$upost=$post;
			$comments="";
			$id=$row['postid'];
			$template->file_register("studentpost","templates/li.html");
			$template->var_register("studentpost","uimgsrc,ufname,upost,id,comments,posterid,userid");
			$template->file_parse("studentpost");
			$template->display_page("studentpost");
				
			$count++;
		}
	}


$min=$min-1;
$query7="UPDATE activity_state SET minpost='$min' WHERE userid='$userid'";
mysqli_query($dbcon1,$query7) or die("query not fired at showstudentposts_comm.php query7");
mysqli_close($dbcon1);
}
?>
