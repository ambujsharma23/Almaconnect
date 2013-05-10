<?php
include 'core/template.php';
include 'patches/datevars.php';

if($fpava_setses)
	{
		$userid=$_SESSION['userid'];
		$email=$_SESSION['email'];
		$id=$userid;				//li Template variable id
		$dbcon=mysqli_connect($fpava_dbip,$fpava_user,$fpava_pass,$fpava_dbname) or die("almaconnect not connected in index.php");
		$query1="SELECT photo FROM site_tb WHERE userid='$userid'";
		$result1=mysqli_query($dbcon,$query1);
		$row=mysqli_fetch_array($result1);
		$image=$row['photo'];
		if($image!="blank.jpeg")
		{
			$image=fpava_imgpath.$row['photo'];
	 }
		$query3="select * from college_tb where coll_em='$email'";
		$result3=mysqli_query($dbcon,$query3) or die("error in query in index.php");
		if(mysqli_num_rows($result3)==1)
			{
				$row=mysqli_fetch_array($result3);
				if($row['register']==T)
				{
				$type=$row['coll_mt'];
				$course=$row['coll_dis'];
				$jy=$row['coll_jy'];
				if($course=="BTech")
				{
					$fixed_mon=$BTech_fixed_mon;
					$fixed_date=$BTech_fixed_date;
					$duration=$BTech_duration;
				}
				elseif($course=="MCA")
				{
					$fixed_mon=$MCA_fixed_mon;
					$fixed_date=$MCA_fixed_date;
					$duration=$MCA_duration;
				}
				$jy_mk=mktime(0,0,0,$fixed_mon,$fixed_date,$jy);
				$nxt_mk=mktime(0,0,0,$fixed_mon,$fixed_date,$jy+$duration);
				$curr_date=date("d");
				$curr_mon=date("m");
				$curr_yr=date("Y");
				$curr_mk=mktime(0,0,0,$curr_mon,$curr_date,$curr_yr);

				$input1=strtoupper($_SESSION['fullname']);

				if($type=="student")
					{
						if($curr_mk<$nxt_mk)
							{
								$temp=1;
								while($temp<=$duration)
									{
										if($curr_mk<mktime(0,0,0,$fixed_mon,$fixed_date,$jy+$temp))
										{
											$input3="Year:".$temp;
											break;
										}
										else
										{
											$temp=$temp+1;
										}
									}
							}
						else
							{
								$input3="BATCH : ".$jy."-".($jy+$duration);
								$query4="UPDATE college_tb SET coll_mt='alumini' WHERE coll_em='$email'";
								mysqli_query($dbcon,$query4) or die("1_2_comm.php query4");
								
								$query5="UPDATE site_tb SET site_mt='alumini' WHERE userid='$userid'";
								mysqli_query($dbcon,$query5) or die("1_2_comm.php query5");
							}
						$input2=strtoupper($row['coll_br']);
						$input4="";
						$template->file_register($filekey,$filename);
						$template->var_register($filekey,"input1,input2,input3,input4,image,id,userid,pagetype");
						$template->file_parse($filekey);
						$template->display_page($filekey);
						mysqli_close($dbcon);
					}
				elseif($type=="alumini")
					{
					if($curr_mk>$nxt_mk) 
							{
								$input2="BATCH : ".$jy."-".($jy+$duration);
								$query4="SELECT college_pos.coll_pos,college_pos.coll_dept from college_pos,college_tb WHERE college_tb.coll_em='$email' AND college_pos.coll_id=college_tb.coll_id";
								$result4=mysqli_query($dbcon,$query4) or die("could not query"); 
								if(mysqli_num_rows($result4)==1)
								{
									$row=mysqli_fetch_array($result4);
									$input3=strtoupper($row['coll_pos']);
									$input4=strtoupper($row['coll_dept']);
								}
								else
								{
									$input3="";
									$input4="ALUMINI";
								}
								$template->file_register($filekey,$filename);
								$template->var_register($filekey,"input1,input2,input3,input4,image,id,userid,pagetype");
								$template->file_parse($filekey);
								$template->display_page($filekey);
								mysqli_close($dbcon);
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
						}
						else
						{
							$input2="FACULTY";
						}
						$input4="SINCE"." ".$jy;
						$template->file_register($filekey,$filename);
						$template->var_register($filekey,"input1,input2,input3,input4,image,id,userid,pagetype");
						$template->file_parse($filekey);
						$template->display_page($filekey);
						mysqli_close($dbcon);

					}
				else
					{
						echo "not done";
					}
				}
			}
 }
?>
