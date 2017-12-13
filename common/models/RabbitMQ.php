<?php

namespace common\models;


use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class RabbitMQ
{

    private $connection;
    private $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare('tbot_queue');
    }

    /**
     * @param $infoSourceId
     * @return array
     */
    public function indexTelegramChannel($infoSourceId)
    {
        $taskType  = "index_telegram_channel";
        $data = ['task_type' => $taskType, 'task_data' => ['info_source_id' => $infoSourceId]];
        $this->sender($taskType, $data);
        return $data;
    }


    /**
     * @param $postId
     * @return array
     */
    public function searchPostForMentions($postId)
    {
        $taskType  = "search_post_for_mentions";
        $data = $data = ['task_type' => $taskType, 'task_data' => ['post_id' => $postId]];
        $this->sender($taskType, $data);
        return $data;
    }

    /**
     * @param $taskType
     * @param $data
     */
    private function sender($taskType, $data)
    {
        $msg = new AMQPMessage(json_encode($data));
        $this->channel->basic_publish($msg, '', 'tbot_queue');
        $this->channel->close();
        $this->connection->close();
    }
}