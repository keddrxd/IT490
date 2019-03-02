<?php
Require_once("resource/Assignment1.html");

?>

<div id = "loginbox">

<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("RMQ.ini","database");
if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test";
}

$request = array();
$request = ['type'] = "login";
$request = ['username'] = $_GET["user"];
$request = ['password'] = $_GET["password"];
$request = ['message'] = $msg;
$response = $client->send_request($request);

if ($response == true)
{
  echo '<p style="font-size:30px; color: green" align="center">Logged In Successfully.';
  echo '<p style="font-size:20px; align="center">Redirecting to Welcome Page.';
}

else
{
  echo '<p style="font-size:30px; color: red" align=center>Login Declined</p>';
  echo '<p style="font-size:20px; align="center">Redirecting to Login Page.';
 }
 echo "\n\n";
?>
</div>
<?php 

?>

