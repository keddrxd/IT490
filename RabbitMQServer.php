#!/usr/bin/php
<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function dbRequest($request)
{
	
	$client = new rabbitMQClient("db.ini","testServer");
	if (isset($arg[1]))
	{
		$msg=$argv[1];
	}
	else
	{
		$msg = "test message";	
	}
	$response = $client->send_request($request);
	if ($response == true)
	{
		echo "Yes";
	}
	else
	{
		echo "No";
	}
	return $response;
	
	
}
function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
	  case "login":
		return dbRequest($request);
	  
	  
	  
	  
	  
	  
  }
  return array("returnCode" => '0','message'=>"Server received request and processed");
  $server = new rabbitMQServer("Main.ini","testServer");
  echo "MainRabbitMQServer Began".PHP_EOL;
  $server->process_requests('requestProcessor');
  echo "MainRabbitMQServer Ends".PHP_EOL;
  exit();
}





?>
