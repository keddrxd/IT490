<?php

require_once _DIR_ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class msgReceiver
{
	public function msgListen()
	 {

		$connection = new AMQPConnection('192.168.1.4', 5672, 'adam', 'adam');
		$channel = $connection->channel();

		$channel->queue_declare('beQueue',false,false,false,false);

		$data = json_encode($_POST);
		$msg = new AMQPMessage($data, array('delivery_mode' => 2));
		$channel->basic_publish($msg, 'beExchange','beQueue');
		while(count($channel->callbacks))
		{
			$channel->wait();
		}
		$channel->close();
		$connection->close();
	}
	public function redirect($response)
	{
    		if($response=="S")
		{
		    header('Location: homepage.html');
		}
		else
		{	
	    	    header('Location: failure.html');
		}
	}
}
$receiver = new msgReceiver();
$userLogin = $_POST["username"] . "~" . $_POST["password"];
$response = $receiver->call($userLogin);
redirect($response);
?>
