<?php
session_start();
if(isset($_SESSION['fullname']) and isset($_SESSION['userid']) and isset($_SESSION['email']))
	{
		$id=$_GET['id'];
		$userid=$_SESSION['userid'];
		if($id==$userid)
			$id=$userid;
		$filekey="profile";
		$filename="profile.html";
		define('GW_UPLOADPATH','images/');
//		$userid=$_SESSION['userid'];
		$dbcon=mysqli_connect("localhost","root","ambujsharma","almaconnect") or die("almaconnect not connected in index.php");
		$query1="SELECT photo,site_em FROM site_tb WHERE userid='$id'";
		$result1=mysqli_query($dbcon,$query1);
		$row=mysqli_fetch_array($result1);
		$image=$row['photo'];
		$email=$row['site_em'];
		if($image!="blank.jpeg")
		{
			$image=GW_UPLOADPATH.$row['photo'];
	 }
//		$email=$_SESSION['email'];
		$query3="select * from college_tb where coll_em='$email'";
		$result3=mysqli_query($dbcon,$query3) or die("error in query in index.php");
		if(mysqli_num_rows($result3)==1)
			{
				$row=mysqli_fetch_array($result3);
				$fn=$row['coll_fn'];
				$ln=$row['coll_ln'];
				$name=$fn." ".$ln;
				$type=$row['coll_mt'];
				$dob=$row['coll_dob'];
				$jy=$row['coll_jy'];
				$fixed_mon=7;
				$fixed_date=15;
//				setting timezone
				date_default_timezone_set('UTC');
				
				$jy_mk=mktime(0,0,0,$fixed_mon,$fixed_date,$jy);
				$nxt_mk=mktime(0,0,0,$fixed_mon,$fixed_date,$jy+4);
				$curr_date=date("d");
				$curr_mon=date("m");
				$curr_yr=date("Y");
				$curr_mk=mktime(0,0,0,$curr_mon,$curr_date,$curr_yr);

//				$input1=strtoupper($_SESSION['fullname']);
				$input1=$name;
				include("template.php");
				$template=new template;

				if($type=="student")
					{
						if($curr_mk<$nxt_mk)
							{
								if($curr_mk<mktime(0,0,0,$fixed_mon,$fixed_date,$jy+1))
									{
										$input3="1"."<sup>st</sup>yr";
									}
								elseif($curr_mk<mktime(0,0,0,$fixed_mon,$fixed_date,$jy+2))
									{
										$input3="2"."<sub>nd</sub>yr";
									}
								elseif($curr_mk<mktime(0,0,0,$fixed_mon,$fixed_date,$jy+3))
									{
										$input3="3"."<sub>rd</sub>yr";
									}
								elseif($curr_mk<mktime(0,0,0,$fixed_mon,$fixed_date,$jy+4))
									{
										$input3="4"."<sup>th</sup>yr";
									}
								$input2=strtoupper($row['coll_br']);
								$input4="STUDENT";
								$template->file_register($filekey,$filename);
								$template->var_register($filekey,"input1,input2,input3,input4,image,dob,type,email,id,userid");
								$template->file_parse($filekey);
								$template->display_page($filekey);
								mysqli_close($dbcon);
							}
					}
				elseif($type=="alumini")
					{
						if($curr_mk>$nxt_mk)
							{
								$input2="BATCH : ".$jy."-".($jy+4);
								$query4="SELECT college_pos.coll_pos,college_pos.coll_dept from college_pos,college_tb WHERE college_tb.coll_em='$email' AND college_pos.coll_id=college_tb.coll_id";
								$result4=mysqli_query($dbcon,$query4);
								if(mysqli_num_rows($result4)==1)
								{
									$row=mysqli_fetch_array($result4);
									$input3=strtoupper($row['coll_pos']);
									$input4=strtoupper($row['coll_dept']);
									$template->file_register($filekey,$filename);
									$template->var_register($filekey,"input1,input2,input3,input4,image,dob,type,email,id,userid");
									$template->file_parse($filekey);
									$template->display_page($filekey);
									mysqli_close($dbcon);
								}
							}
					}
				elseif($type=="faculty")
					{
						$input3=$row['coll_br'];
						$query5="SELECT college_pos.coll_pos,college_pos.coll_dept from college_pos,college_tb WHERE college_tb.coll_em='$email' AND college_pos.coll_id=college_tb.coll_id";
						$result5=mysqli_query($dbcon,$query5);
						if(mysqli_num_rows($result5)==1)
						{
							$row=mysqli_fetch_array($result5);
							$input2=strtoupper($row['coll_pos']);
							$input4="SINCE"." ".$jy;
							$template->file_register($filekey,$filename);
							$template->var_register($filekey,"input1,input2,input3,input4,image,dob,type,email,id,userid");
							$template->file_parse($filekey);
							$template->display_page($filekey);
							mysqli_close($dbcon);
						}
					}
			}
 }
?>
