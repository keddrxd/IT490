<?php

require_once(__DIR__.'/../../../vendor/autoload.php');
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$host = 'localhost';
$port = 5672;
$user = 'adam';
$pass = 'adam';
$vhost = 'beHost';
$exchange = 'beExchange';
$queue = "beQueue";

$connection = new AMQPStreamConnection($host,$port,$user,$pass);
$channel = $connection->channel();

$channel->queue_declare($queue,true,true,false,false);
$channel->exchange_declare($exchange,'direct',false,true,false);
$channel->queue_bind($queue,$exchange);

$messageBody = json_decode(['user' => 'adam', 'password' => 'adam',]);



?>
