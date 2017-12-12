<?php


namespace common\models;




use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabitMQ
{

    private $connection;
    private $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
    }
}