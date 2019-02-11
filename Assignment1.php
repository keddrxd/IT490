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

function withdraw($user, $amount)
{
	global $db;
	$s  =  "select * from  A where user = '$user'" ;
	($t = mysqli_query( $db,$s ) )  or die( mysqli_error($db) );
	while ( $r = mysqli_fetch_array($t,MYSQLI_ASSOC) ) {
		$cur = $r["cur_balance"];
		if($cur > $amount)
		{
			$up = "UPDATE A SET cur_balance = cur_balance - $amount WHERE user = '$user'";
			mysqli_query($db,$up) or die (mysqli_error());

	
			$in = "INSERT INTO T (user, type, amount, date) VALUES ('$user', 'W', '$amount', NOW())";
			mysqli_query($db,$in) or die (mysqli_error());
			
			print "<br>Type of Transaction: W<br>";
			print "Amount of Transaction: $$amount";
			
		}else{
			print "<br>NOT ENOUGH IN ACCOUNT TO WITHDRAW!<br><br>Available Balance: $cur<br>Amount Attempted to Withdraw: $amount";
			
		}	
}
}

function deposit($user, $amount)
{
	global $db;
	
	$up = "UPDATE A SET cur_balance = cur_balance + $amount WHERE user = '$user'";
	mysqli_query($db,$up) or die (mysqli_error());

	
	$in = "INSERT INTO T (user, type, amount, date) VALUES ('$user', 'D', '$amount', NOW())";
	mysqli_query($db,$in) or die (mysqli_error());
	
	print "<br>Type of Transaction: D<br>";
	print "Amount of Transaction: $$amount";
}

function show ($username, &$out){

 global $db; 
 $s  =  "select * from  A where user = '$username'" ;
 $out .= "<br>SQL statement is: $s<br><br>"; 
 ($t = mysqli_query( $db,$s ) )  or die( mysqli_error($db) );
 $k = "select * from T where user = '$username'";
 ($p = mysqli_query( $db,$k ) )  or die( mysqli_error($db) );

 while ( $r = mysqli_fetch_array($t,MYSQLI_ASSOC) ) {

	$username = $r[ "user" ];
	$curbalance = $r[ "cur_balance" ];
	$fullname = $r["fullname"];
	$email = $r["mail"];
	$init = $r["init_balance"];
	$number = $r["cell"];  
	$out .= "Username is: $username<br>";
	$out .= "User's full name is: $fullname<br>";
	$out .= "User's email address is: $email<br>";
	$out .= "User's cell phone number is: $number<br>";
	$out .= "User's initial balance was: $$init<br>";
	$out .= "User's current balance is: $$curbalance<br><br>";
 }
 while ( $r = mysqli_fetch_array($p,MYSQLI_ASSOC) ) {
	  
	  $type = $r["type"];
	  $amount = $r["amount"];
	  $date = $r["date"];
	  $out .= "==================================";
	  $out .= "<br>Type of transaction: $type<br>";
	  $out .= "Amount of transtation: $$amount<br>";
	  $out .= "Date of transation: $date<br>";	  
  } 
   
  echo $out; 
}

function mailer ( $username , $out )
{
	global $db; 
	$s  =  "select * from  A where user = '$username'" ;
	$t = mysqli_query ($db , $s);
	while ( $r = mysqli_fetch_array($t,MYSQLI_ASSOC) ) 
	{
		$mail = $r["mail"];
		$name = $r["fullname"];
		$to = $mail;
		$subject = "Hello, $name!";
		$message = $out;  
		mail ( $to, $subject, $message ); 
	}

	 
}


?>