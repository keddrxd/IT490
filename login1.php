<?php

include(__DIR__ . '/config.php');
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$host = '192.168.1.4';
$port = 5672;
$user = 'adam';
$pass = 'adam';
$vhost = 'beHost';
$exchange = 'beExchange';
$queue = "beQueue";

$connection = new AMQPStreamConnection($host,$port,$user,$pass,$vhost);
$channel = $connection->channel();

$channel->queue_declare($queue,true,true,false,false);
$channel->exchange_declare($exchange,'direct',false,true,false);
$channel->queue_bind($queue,$exchange);

$messageBody = json_decode(['user' => 'adam', 'password' => 'adam',]);



?>
