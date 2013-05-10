<?php
include 'core/template.php';
include 'patches/variables.php';

class json1
{
	$cl_json1_posts;
	
	function json1()
	{
		$this->cl_json1_posts=array();
	}

	function getposts($dbip,$user,$pass,$dbname,$uid)
	{
		$dbcon=mysqli_connect($dbip,$user,$pass,$dbname) or die("getall.php, json1.cl, getposts.fn, dbcon");
		$query1="SELECT maxpost FROM activity_state WHERE userid='$uid'";
		$result1=mysqli_query($dbcon,$query1) or die("getall.php, json1.cl, getposts.fn, query1");
		$row1=mysqli_fetch_array($result1) or die("getall.php, json1.cl, getposts.fn, row1");
		$maxpost=$row1['maxpost'];

		$query2="SELECT * FROM user_posts WHERE postid>'$maxpost' AND userid!='$uid' order by postid desc";
		$result2=mysqli_query($dbcon,$query2) or die("getall.php, json1.cl, getposts.fn, query2");

		while($row2=mysqli_fetch_array($result2))
		{
			
		}

	}
}

echo "hello";
/*
if($fpava_setses)
{
	$userid=$_SESSION['userid'];
	$email=$_SESSION['email'];

	$obj=new json1($userid,$email);

	$obj->getposts();
	$json=json_encode($obj);
	echo $json;
}*/
?>
