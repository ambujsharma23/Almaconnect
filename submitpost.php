<?php
include 'core/template.php';
include 'patches/variables.php';

$rawpost=$_POST['share_ta'];
$userid=$_SESSION['userid'];
$fullname=$_SESSION['fullname'];
$date=date("d-m-Y-H-i-s");
$dbcon=mysqli_connect($fpava_dbip,$fpava_user,$fpava_pass,$fpava_dbname) or die("could not connect");
$post=mysqli_real_escape_string($dbcon,trim($rawpost));
$query="INSERT INTO user_posts(userid,poster_name,posts,time) VALUES('$userid','$fullname','$post','$date')";
mysqli_query($dbcon,$query) or die("could not query");

//setting the posts here

$query4="SELECT photo FROM site_tb WHERE userid='$userid'";
$result4=mysqli_query($dbcon,$query4);
$row4=mysqli_fetch_array($result4);
$uimgsrc=fpava_imgpath.$row4['photo'];
$ufname=strtoupper($_SESSION['fullname']);

//Taking out postid of the saved post
$query5="SELECT postid FROM user_posts where posts='$post' AND userid='$userid' AND time='$date'";
$result5=mysqli_query($dbcon,$query5);
$row5=mysqli_fetch_array($result5);
$postid=$row5['postid'];
//initialising comments parameters in activity_state_table
$query6="INSERT INTO activity_state_comment(postid) VALUES('$postid')";
mysqli_query($dbcon,$query6);

$upost=$post;
$comments=""; 																																																						//To change

$template->file_register("post","templates/li.html");
$template->var_register("post","uimgsrc,ufname,upost,comments");	
$template->file_parse("post");
$template->display_page("post");
?>
