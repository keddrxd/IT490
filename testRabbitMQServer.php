#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
#hi

include ("account.php");

$userdatabase = mysqli_connect($hostname, $username, $password, $project);

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
	$s = "SELECT * from Users where Username = \"$username\" && Password = \"$password\"";
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
      return doLogin($request['username'],$request['password']);
    case "validate_session":
      return doValidate($request['sessionId']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}	
	
	
}
$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>









































?>
