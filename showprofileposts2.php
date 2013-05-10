<?php
$count=0;
$query6="SELECT user_posts.postid, user_posts.poster_name, user_posts.posts, user_posts.time FROM user_posts WHERE user_posts.postid<='$max' AND user_posts.userid='$id' ORDER BY user_posts.postid DESC";
	$result6=mysqli_query($dbcon1,$query6) or die("query not fired at showprofileposts2.php query6");
	if(mysqli_num_rows($result6))
	{
		while($row=mysqli_fetch_array($result6) and $count<20)
		{
			$poster_name=$row['poster_name'];
			$post=$row['posts'];
			$min=$row['postid'];
	
			define('GW_UPLOADPATH','images/');
			$query4="SELECT photo FROM site_tb WHERE userid='$id'";
			$result4=mysqli_query($dbcon1,$query4);
			$row4=mysqli_fetch_array($result4);
			$uimgsrc=GW_UPLOADPATH.$row4['photo'];
			$ufname=$poster_name;
			$upost=$post;
			$comments="";
			$posterid=$id;
			$template->file_register("profilepost","li.html");
			$template->var_register("profilepost","uimgsrc,ufname,upost,comments,posterid");
			$template->file_parse("profilepost");
			$template->display_page("profilepost");
					
			$count++;
		}
	}


$min=$min-1;
$query7="UPDATE activity_state SET minpost='$min' WHERE userid='$id'";
mysqli_query($dbcon1,$query7) or die("query not fired at showprofileposts2.php query7");
mysqli_close($dbcon1);
?>
