<?php
include 'patches/variables.php';

if(isset($_POST['signin']) or isset($_POST['joinnow']))
{
	if($fpava_ntsetcoo)
	{
		if(isset($_POST['signin']))
			{
				$input=$_POST['signin_email'];
				$password=$_POST['signin_password'];
				$checkbox=$_POST['remember'];
				$pattern='/\w+@\w+\W\w+/';
				$var=preg_match($pattern,$input);
				$dbcon=mysqli_connect($fpava_dbip,$fpava_user,$fpava_pass,$fpava_dbname) or die("could not connect");
				if($var==1)
				{
					$email=$input;
					$query="select * from site_tb where site_em='$email'";
				}
				else
				{
					$username=$input;
		 		$query="select * from site_tb where username='$username'";							//NOT TESTED
				}
				$result=mysqli_query($dbcon,$query) or die("query not fired");
				$num=mysqli_num_rows($result);
				if($num==1)
					{
						$row=mysqli_fetch_array($result);
						if($password==$row['password'])
							{
								$userid=$row['userid'];
								$email=$row['site_em'];
								$fn=$row['site_fn'];
								$ln=$row['site_ln'];
								$fullname=$fn." ".$ln;
							}
						else
							{
								//echo "username and password did not match";

								session_destroy();
								header('location:http://localhost/ambuj/connect/index.php');
							}
					}
				mysqli_close($dbcon);
			}
	
		else if(isset($_POST['joinnow']))
			{
				$username=$_POST['username'];
				$password=$_POST['pass1'];
				$checkbox=$_POST['remember'];
				$email=$_POST['hiddenemail'];
				$userid=$_POST['hiddenid'];

				$dbcon=mysqli_connect($fpava_dbip,$fpava_user,$fpava_pass,$fpava_dbname) or die("connection not established");
				$query="UPDATE site_tb SET username='$username',password='$password' where userid='$userid'";
				mysqli_query($dbcon,$query) or die("query not fired in main.php");
	
//Mailing password to user
				$to=$email;
				$sub="Thanks for joining almaconnect";
				$msg="Your password is CHECK";
				$from="ambujsharma23@gmail.com";
				mail($to,$sub,$msg,'from:'.$from);


//Connecting to site_tb to get session variables
				$query2="select site_fn,site_ln from site_tb where userid='$userid'";
				$result2=mysqli_query($dbcon,$query2);
				$num2=mysqli_num_rows($result2);
				if($num2==1)
					{
						$row=mysqli_fetch_array($result2);
						$fn=$row['site_fn'];
						$ln=$row['site_ln'];
						$fullname=$fn." ".$ln;

//setting activity table 
						$query2="INSERT INTO activity_state(userid) VALUES('$userid')";
						mysqli_query($dbcon,$query2) or die("error in insert in index.php.activity");
						mysqli_close($dbcon);
							
					}
			}
	
//Making session and cookies

					$_SESSION['fullname']=$fullname;
					$_SESSION['userid']=$userid;
					$_SESSION['email']=$email;
					if($checkbox=="yes")
						{
//setting cookie
							setcookie('fullname',$fullname,time()+60*60*24*30);
							setcookie('userid',$userid,time()+60*60*24*30);
							setcookie('email',$email,time()+60*60*24*30); 
						}

				}			
			}

if($fpava_setses)
{
	$filekey="home";
	$filename="templates/mainpage.html";
	$pagetype="home";
	include("1_2_comm.php");
}
else
{
	header("location:http://localhost:80/ambuj/connect/index.php");
}
?>
