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
        $this->connection = new AMQPStreamConnection('185.16.42.168', 5672, 'tbot', 'ASDFwEWEW');
        $this->channel = $this->connection->channel();
    }

    /**
     * @param $infoSourceId
     * @return array
     */
    public function indexTelegramChannel($infoSourceId)
    {
        $taskType  = "index_telegram_channel";
        $data = ['task_type' => $taskType, 'task_data' => ['info_source_id' => $infoSourceId]];
        $this->sender($data, 'tbot_notification');
        return $data;
    }


    /**
     * @param $postId
     * @return array
     */
    public function searchPostForMentions($post)
    {
        $taskType  = "search_post_for_mentions";
        $data = $data = ['task_type' => $taskType, 'task_data' => ['post' => $post]];
        $this->sender($data, 'tbot_message_analyze');
        return $data;
    }

    /**
     * @param $data
     * @param $channelName
     */
    private function sender($data, $channelName)
    {
        $this->channel->queue_declare($channelName);
        $msg = new AMQPMessage(json_encode($data));
        $this->channel->basic_publish($msg, '', $channelName);
        $this->channel->close();
        $this->connection->close();
    }
}