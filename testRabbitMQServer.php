#!/usr/bin/php

<?php
#require_once('path.inc');
#require_once('get_host_info.inc');
#require_once('rabbitMQLib.inc');


include ("account.php");

function doLogin($username,$password)
{
    // lookup username in databas
    // check password
    return true;
    //return false if not valid
}

function authentication($username,$password)
{
	
	global $userdatabase;
	$s = "SELECT * from Users where User = \"$username\" && Password = \"$password\"";
	$t = mysqli_query($Users, $s);
	
	if (mysqli_num_rows($t) == 0)
	{
		echo "Username and password incorrect.";
		return false;
	}
	else
	{
		echo "Username and password correct.";
		return true;
	}
	
	
	
}
$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>









































?>
