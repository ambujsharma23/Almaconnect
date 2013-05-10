<?php

include 'core/template.php';
include 'patches/variables.php';

if($fpava_setses)
	{
		header("location:http://localhost/ambuj/connect/home.php");
	}
else if($fpava_ntsetses)
	{
		if($fpava_ntsetcoo)
			{
				$template->file_register("index","indexshow.html");
				$template->display_page("index");
			}
		else
			{
				$_SESSION["fullname"]=$_COOKIE['fullname'];
				$_SESSION['userid']=$_COOKIE['userid'];
				$_SESSION['email']=$_COOKIE['email'];
				header("location:http://localhost/ambuj/connect/home.php");
			}
	}

?>

