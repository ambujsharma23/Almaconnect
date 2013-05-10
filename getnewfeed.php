<?php
include 'core/template.php';
include 'patches/variables.php';

class MakeJson
{
	var $posts;
	
	function MakeJson()
	{
		$this->posts=array();
	}

}
$obj=new MakeJson();

if(isset($fpava_setses))
{
$userid=$_SESSION['userid'];
// getting the latest postid shown to user 
$dbcon1=mysqli_connect($fpava_dbip,$fpava_user,$fpava_pass,$fpava_dbname);
$query1="SELECT maxpost FROM activity_state where userid='$userid'";
$result1=mysqli_query($dbcon1,$query1) or die("not able to query in getwallpost.sel.as_tb");

if(mysqli_num_rows($result1)==1)
	{
		$row1=mysqli_fetch_array($result1);
		$postid=$row1['maxpost'];

//setting max to calculate highest postid shown		
		$max=$postid;

//taking every post>max to show to user
		$query2="SELECT * FROM user_posts where postid>'$max' and userid!='$userid'";
		$result2=mysqli_query($dbcon1,$query2) or die("could not query in getwallpost.sel.up_tb");
		
		while($row2=mysqli_fetch_array($result2))
			{
				$poster_name=$row2['poster_name'];
				$post=$row2['posts'];
				$postid=$row2['postid'];
				$posterid=$row2['userid'];

 			if($postid>$max)
					{
						$max=$postid;
					}

				$time=$row2['time'];
				$datearr=explode("-",$time);
				list($day,$month,$year,$hour,$minute,$second)=$datearr;
				$currentts=mktime($hour,$minute,$second,$month,$day,$year);

//displaying all user's posts
				
				$query4="SELECT photo FROM site_tb WHERE userid='$posterid'";
				$result4=mysqli_query($dbcon1,$query4);
				$row4=mysqli_fetch_array($result4);
				$uimgsrc=fpava_imgpath.$row4['photo'];
				$id=$postid;
				$ufname=strtoupper($poster_name);
				$upost=$post;
				$comments="";

//using template
				$template->file_register("newpost","templates/li.html");
				$template->var_register("newpost","uimgsrc,id,ufname,upost,comments");
				$singlepost=$template->file_parse2("newpost");                          //changed for json;
				array_push($obj->posts,$singlepost);
			}

		echo json_encode($obj);
		$query3="UPDATE activity_state SET maxpost='$max' where userid='$userid'";
		mysqli_query($dbcon1,$query3) or die("could not query getwallpost.insert.as_tb");
		mysqli_close($dbcon1);
	}
}
?>
