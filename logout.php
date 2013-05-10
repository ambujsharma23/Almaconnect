<?php

include 'patches/variables.php';

if($fpava_setses)
	{
		$_SESSION=array();
	}
if(isset($_COOKIE[session_name()]))
	{
		setcookie(session_name(),'',time()-3600);
	}
session_destroy();
setcookie('fullname','a',time()-3600);
setcookie('userid','b',time()-3600);
setcookie('email','c',time()-3600);
header("location: http://localhost:8080/connect/index.php");

?>
