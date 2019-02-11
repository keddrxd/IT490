#!/usr/bin/php
<?php





function auth($userName, $passWord)
{
	include ("account.php");
	global $db;
	$s = "select * from A";
	$t = mysqli_query ($db , $s);
	$rows = mysqli_num_rows($t);
	
	if(numRows($rows) == false)
	{
			return false;
	}
	while ($r = mysqli_fetch_array($t,MYSQL_ASSOC))
	{
		$user = $r["user"];
		$pass = $r["pass"];
		
		if($userName == $user && $passWord == $pass)
		{
			print "<br>Input accepted and credentials validated.<br><br>";
			print "<br>Username is: $user<br>Password is: $pass<br>";
			
			return true;
		}
	}
	print "<br>Bad Credentials, please try again.";
	return false;	
}

?>