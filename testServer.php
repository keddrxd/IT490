#!usr/bin/php
<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


function connectSQL()
{
	$db = new mysqli('192.168.1.8','Admin','Admin','Users');
	
	if ($db -> errno !=0)
	{
		echo "Cannot connect to mySQL: ".$db->error . PHP_E0L;
		exit(0);
	
	}
	echo "Connected to mySQL Database".PHP_E0L;
}

function requestProcessor($request)
{
	echo "received request".PHP_E0L;
	var_dump($request);
	if(!isset($request['type']))
	{
		return "ERROR: unsupported message type";
	}
	switch ($request['type'])
	{
		case "login":
			return connectSQL;
		case "validate_session":
			return doValidate($request['sessionId']);
	}
	return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server =  new rabbitMQServer("testRabbitMQ.ini","testServer");
echo "RabbitMQ Server Began". PHP_E0L;
$server->process_requests('requestProcessor');
echo "RabbitMQ Server Ended". PHP_E0L;
exit();
	
	
	







































?>
