<?php
include 'core/template.php';

			if($max>20)
				$min=$max-20;
			else
				$min=0;

			$query3="SELECT * FROM user_posts WHERE postid>'$min' AND postid<='$max' ORDER BY postid DESC";

			$result3=mysqli_query($dbcon1,$query3) or die("query not fired in homefeed sel_up");
			if(mysqli_num_rows($result3))
				{

					while($row=mysqli_fetch_array($result3))
						{
							
							$posterid=$row['userid'];
							$ufname=strtoupper($row['poster_name']);
							$upost=$row['posts'];
							$postid=$row['postid'];
							$poid=$postid;
							$query4="SELECT photo FROM site_tb WHERE userid='$posterid'";
							$result4=mysqli_query($dbcon1,$query4);
							$row4=mysqli_fetch_array($result4);
							$uimgsrc=fpava_imgpath.$row4['photo'];

							$query5="SELECT COUNT(postid) as noofcomments FROM comment_tb where postid='$postid'";
							$result5=mysqli_query($dbcon1,$query5);
							$row5=mysqli_fetch_array($result5);
							$noofcomments=$row5['noofcomments'];

							$maxcid=0;
							$mincid=0;
							$arr=array();
							$comments="";

							if($noofcomments>3)
							{								
								$query6="SELECT * FROM comment_tb WHERE postid='$postid' ORDER BY commentid DESC LIMIT 3";
								$result6=mysqli_query($dbcon1,$query6);
								while($row6=mysqli_fetch_array($result6))
								{
							 	$commenterid=$row6['userid'];
									$comment=$row6['comment'];
									$commentid=$row6['commentid'];
									if($commentid>$maxcid)
									{
										$maxcid=$commentid;
										$mincid=$maxcid-3;
									}

									$query7="SELECT site_fn,site_ln FROM site_tb WHERE userid='$commenterid'";
									$result7=mysqli_query($dbcon1,$query7);
									$row7=mysqli_fetch_array($result7);
									$fn=$row7['site_fn'];
									$ln=$row7['site_ln'];
									$cname=ucwords($fn." ".$ln);

									$template->file_register("commentfile","templates/commentli.html");
									$template->var_register("commentfile","commenterid,cname,comment,commentid");
									$single=$template->file_parse2("commentfile");
									array_push($arr,$single);
								}
								foreach($arr as $value)
								{
									$comments=$comments.$value;
								}//End of While

							//$othercomments="<a href=\"#\" style=\"color:#ff0000\" onclick=\"viewComment();\">View all ".$noofcomments." comments</a>";

							$query10="UPDATE activity_state_comment SET maxcid='$maxcid',mincid='$mincid' WHERE postid='$postid'";
							mysqli_query($dbcon1,$query10);


							$othercomments="";																																												// To Change
							$template->file_register("allposts","templates/li.html");
							$template->var_register("allposts","poid,uimgsrc,posterid,ufname,upost,comments,othercomments");
							$template->file_parse("allposts");
		 				$template->display_page("allposts");
						}

						elseif($noofcomments>0 and $noofcomments<=3)
							{
								$query6="SELECT * FROM comment_tb WHERE postid='$postid' ORDER BY commentid DESC LIMIT $noofcomments";
								$result6=mysqli_query($dbcon1,$query6);

								while($row6=mysqli_fetch_array($result6))
								{
									$commentid=$row6['commentid'];
									$commenterid=$row6['userid'];
									$comment=$row6['comment'];

									if($commentid>$maxcid)
									{
										$maxcid=$commentid;
										$mincid=$maxcid-$noofcomments;
									}
									$query7="SELECT site_fn,site_ln FROM site_tb WHERE userid='$commenterid'";
									$result7=mysqli_query($dbcon1,$query7);
									$row7=mysqli_fetch_array($result7);
									$fn=$row7['site_fn'];
									$ln=$row7['site_ln'];
									$cname=ucwords($fn." ".$ln);

									$template->file_register("commentfile","templates/commentli.html");
									$template->var_register("commentfile","commenterid,cname,comment,commentid");
									$single=$template->file_parse2("commentfile");
									array_push($arr,$single);
								}
								foreach($arr as $value)
								{
									$comments=$comments.$value;
								}

							$query10="UPDATE activity_state_comment SET maxcid='$maxcid',mincid='$mincid' WHERE postid='$postid'";
							mysqli_query($dbcon1,$query10);

							$othercomments="";
							$template->file_register("allposts","templates/li.html");
							$template->var_register("allposts","poid,uimgsrc,posterid,ufname,upost,comments,othercomments");
							$template->file_parse("allposts");
		 				$template->display_page("allposts");
						}
						else
						{
							$othercomments="";
							$template->file_register("allposts","templates/li.html");
							$template->var_register("allposts","poid,uimgsrc,posterid,ufname,upost,comments,othercomments");
							$template->file_parse("allposts");
		 				$template->display_page("allposts");
						}
		
					}
			$query4="UPDATE activity_state SET minpost='$min' WHERE userid='$userid'";
			mysqli_query($dbcon1,$query4) or die("query not fired in homefeed up_as");
			mysqli_close($dbcon1);
				}
?>
