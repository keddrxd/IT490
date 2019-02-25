#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

include ("account.php");


	$database = mysqli_connect($hostname, $username, $password, $project);

global $database;
if (mysqli_connect_errno())
{
	echo "failed to connect to MySQL: "."\n". mysqli_connect_error();
	exit();
}else	
{
		
	echo "Successfully connected to MYSQL."."\n".PHP_E0L;
}

function authentication($username,$password)
{
	global $database;
	$s = "SELECT * from Users where username =\"%username\" && password = \"$password\"";
	$t = mysqli_query($database,$s);
	
	if (mysqli_num_rows($t) == 0)
	{
		echo "Username and password is not correct.".PHP_E0L;
		return false;
	}
	else
	{
		"Success.".PHP_E0L;
		return true;
	}
	
	
	
	
	
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
echo "testRabbitMQServer BEGIN".PHP_E0L;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_E0L;
exit();
?>
