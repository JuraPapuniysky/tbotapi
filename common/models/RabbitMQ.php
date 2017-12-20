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
    public function indexTelegramChannel(InfoSource $infoSource)
    {
        $taskType  = "index_telegram_channel";
        $data = ['task_type' => $taskType, 'task_data' => ['info_source' => [
            'id' => $infoSource->id,
            'url' => $infoSource->url,
            'info_source_id' => $infoSource->id,
            'access_hash' => $infoSource->access_hash,
        ]]];
        $this->sender($data, 'tbot_notification');
        return $data;
    }


    /**
     * @param $postId
     * @return array
     */
    public function searchPostForMentions(Post $post)
    {
        $taskType  = "search_post_for_mentions";
        $data  = ['task_type' => $taskType, 'task_data' => ['post' => [
            'id' => $post->id,
            'info_source_id' => $post->infoSource->info_source_id,
            'post_url' => $post->post_url,
            'post_data' => $post->post_data,
            'post_views' => $post->post_views,
            'published_datetime' => $post->published_datetime,
            'chat_message_id' => $post->chat_message_id,
        ]]];
        $this->sender($data, 'tbot_message_analyze');
        return $data;
    }

    /**
     * @param $infoSource
     * @return array
     */
    public function updateChannel($infoSource)
    {

        $taskType  = "update_channel";
        $data = $data = ['task_type' => $taskType, 'task_data' => ['info_source' => [
            'id' => $infoSource->id,
            'url' => $infoSource->url,
            'info_source_id' => $infoSource->id,
            'access_hash' => $infoSource->access_hash,
        ]]];
        $this->sender($data, 'tbot__update_content');
        return $data;
    }

    /**
     * @param $post
     * @return array
     */
    public function updatePost($post)
    {
        $taskType  = "update_post";
        $data = $data = ['task_type' => $taskType, 'task_data' => ['message' => [
            'id' => $post->id,
            'info_source_id' => $post->infoSource->info_source_id,
            'post_url' => $post->post_url,
            'chat_message_id' => $post->chat_message_id,
        ]]];
        $this->sender($data, 'tbot_update_content');
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