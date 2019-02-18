<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);  
ini_set('display_errors' , 1);
include ("account.php");
$db =mysqli_connect($hostname, $username, $password, $project);
if (mysqli_connect_errno())
{
    echo "Failed to connect to MYSQL: " . mysqli_connect_error();
    exit();
}
print " <br>Successfully connected to MYSQL.<br>";
$choice = $_GET["type"];
$us = $_GET["user"];
$pass = $_GET["pass"];
$amount = $_GET["amount"];

getData("user", $uss);
if($bad == false)
{
	if(auth($us, $pass) == true){
		if($choice == "")
		{
			print "<br>PLEASE CHOOSE AN OPTION!<br>";
		}
		if($choice == "D")
		{
			deposit($us, $amount);
		}
		if($choice == "S")
		{
			show($us, $out);
			if(!isset($_POST["mail"])) 		
			{
				mailer($us, $out);
			}
		}
		if($choice == "W")
		{
			withdraw($us, $amount);
		}
		
	}
	
	
}

function getData($name, &$result)
{
	global $bad;
	global $db;
	
	if ( ! isset ( $_GET [ $name ] ))
	{
		$bad = true;
		print "Undefined Data";
		return;
	}
	if($_GET[$name] == "")
	{
		$bad = true;
		print "<br>Username and/or password is empty, please enter a correct username and password";
		return;
	}
	
	$result = mysqli_real_escape_string($db, $_GET[$name]);	
}
function numRows($row)
{
	if($row > 0)
	{
		return true;
	}
	return false;	
}

function auth($userName, $passWord)
{
	include ("account.php");
	global $db;
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

	
}
}



	 
}


?>
