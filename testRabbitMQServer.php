#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');




function doLogin($username,$password)
{
	$db = new mysqli('192.168.1.8', 'Admin', 'Admin', 'Users');

	if($db->errno != 0)
	{
		echo "Failed to connect to MySQL" . $db->error . PHP_E0L;
		exit(0);
	}
    // lookup username in databas
    // check password
    return true;
    //return false if not valid
}

/*function authentication($username,$password)
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

	}*/
function auth($username, $password)
{
	include("account.php");
	global $db;
	$s = "SELECT * FROM Users where Username =\"$username\" && Password = \"$password\"";
	$t= mysqli_query ($db, $s);
	$rows= mysqli_num_rows($t);

	if(numRows($rows) == false)
	{
		return false;

	}
	while ($r = mysqli_fetch_array($t, MYSQL_ASSOC))
	{
		$user = $r["Username"];
		$pass = $r["Password"];

		if($username == $user && $password == $pass){
			print "Credentials valiated";

			return true;
		}
	}
	print "Bad Credentials";
	return false;
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
      return auth($request['username'],$request['password']);
    case "validate_session":
      return doValidate($request['sessionId']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}	
	
	
$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>









































?>
