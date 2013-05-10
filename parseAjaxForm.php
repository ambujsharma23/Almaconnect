<?php
include 'patches/variables.php';

$site_fn=strtolower($_POST['fn']);
$site_ln=strtolower($_POST['ln']);
$site_em=$_POST['em'];
$site_dob=$_POST['dob'];
$site_mt=$_POST['mt'];
$site_dis=$_POST['dis'];
$site_jy=$_POST['jy'];

$dbcon=mysqli_connect($fpava_dbip,$fpava_user,$fpava_pass,$fpava_dbname) or die("connection not established");
$query1="select * from college_tb where coll_em='$site_em'";
$result1=mysqli_query($dbcon,$query1) or die("query1 not fired");
$num=mysqli_num_rows($result1);
if($num==1)
{
$row=mysqli_fetch_array($result1);
$register=$row['register'];
$coll_fn=$row['coll_fn'];
$coll_ln=$row['coll_ln'];
$coll_em=$row['coll_em'];
$coll_dob=$row['coll_dob'];
$coll_mt=$row['coll_mt'];
$coll_dis=$row['coll_dis'];
$coll_jy=$row['coll_jy'];

if($register=='F')
{
if($coll_fn==$site_fn && $coll_ln==$site_ln && $coll_mt==$site_mt && $coll_dis==$site_dis && $coll_jy==$site_jy)
	{
		$date1_array = explode("-",$site_dob); 
		$date2_array = explode("-",$coll_dob); 
		$timestamp1 = mktime(0,0,0,$date1_array[1],$date1_array[2],$date1_array[0]); 
		$timestamp2 = mktime(0,0,0,$date2_array[1],$date2_array[2],$date2_array[0]); 
		if ($timestamp1>$timestamp2)
			{
				echo "U have entered wrong DATE OF BIRTH";
			} 
		else if($timestamp1<$timestamp2) 
			{
				echo "U have entered wrong DATE OF BIRTH"; 
			}
		else
			{ 
//Inserting user's data into site database

				$query2="INSERT INTO site_tb(site_fn,site_ln,site_em,site_dob,site_mt,site_dis,site_jy)VALUES('$site_fn','$site_ln','$site_em','$site_dob','$site_mt','$site_dis','$site_jy')";
				mysqli_query($dbcon,$query2) or die("Query2 not fired");

//setting register=T
				$query3="UPDATE college_tb SET register='T' where coll_em='$site_em'";
				mysqli_query($dbcon,$query3) or die("query3 not fired");

//Taking out the userid of the user just joined.

				$query4="SELECT userid FROM site_tb WHERE site_em='$site_em'";
				$result4=mysqli_query($dbcon,$query4) or die("query4 not fired");
				if(mysqli_num_rows($result4)==1)
					{
						$row4=mysqli_fetch_array($result4) or die("row4 not fetched");
						$userid=$row4['userid'];
					
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<p id="newformheader" name="newformheader" style="font-size:17px;">Create Username and Password</p><br/>
<div id="newformcover" name="newformcover">
<form name="newform" id="newform" action="home.php" method="POST">
<label>Username</label><br/>
<input type="text" name="username"/><br/>
<label>Password</label><br/>
<input type="password" name="pass1" id="pass2"/><br/>
<label>Re-enter Password</label><br/>
<input type="password" name="pass2" id="pass2"/><br/>
<input type="checkbox" name="remember" id="remember" value="yes"><label for="checkbox">keep me logged in</label><br/><br/>
<input type="hidden" name="hiddenemail" value="<?php echo $site_em ?>"/>
<input type="hidden" name="hiddenid" value="<?php echo $userid ?>"/>
<input type="submit" name="joinnow" value="Join Now">
</div>
</body>
</html>

<?php
					}
		}
	}
	else
		{
			echo "<p style=\"font-size:15px;\">Please Enter Your Own Information</p>";
		}
	}
	else
	{
		echo "<p style=\"font-size:15px;\">you are a registered user <br/> Something getting wrong <a href=\"#\">Click Here</a></p>";
	}
}
else
{
echo "<p style=\"font-size:15px;\">number of rows not one</p>";
}
mysqli_close($dbcon);
?>

