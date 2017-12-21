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
     * @param Post $post
     * @return array
     */
    public function searchPostForMentions(Post $post)
    {
        $taskType  = "search_post_for_mentions";
        $data  = ['task_type' => $taskType, 'task_data' => ['post' => [
            'id' => $post->id,
            'info_source_id' => $post->infoSource->id,
            'post_url' => $post->post_url,
            'post_data' => $post->post_data,
            'post_views' => $post->post_views,
            'published_datetime' => $post->published_datetime,
            'chat_message_id' => $post->chat_message_id,
        ]]];
        $this->sender($data, 'tbot_message_analyze');
        return $data;
    }

    public function searchChannels()
    {
        $data = ["request" => ['id' => null, 'jsonrpc' => '2.0', 'method' => 'searchChannels', 'params' => ['date' => 0]]];
        $this->sender($data, 'tbot_update_content');
        return $data;
    }

    /**
     * @param $infoSource
     * @return array
     */
    public function updateChannel($infoSource)
    {

        $taskType  = "update_channel";
        $data = $data = ['method' => $taskType, 'task_data' => ['info_source' => [
            'id' => $infoSource->id,
            'name' => '',
            'url' => $infoSource->url,
            'info_source_id' => $infoSource->id,
            'access_hash' => $infoSource->access_hash,
        ]]];
        $this->sender($data, 'tbot_update_content');
        return $data;
    }

    /**
     * @param Post[] $posts
     * @return array
     */
    public function updatePost($posts)
    {
        $taskType  = "updateMessages";
        $messages = [];
        foreach ($posts as $post){
            $message = [
                'channel_id' => $post->infoSource->info_source_id,
                'access_hash' => $post->infoSource->access_hash,
                'channel_name' => $post->infoSource->url,
                'message_id' => $post->chat_message_id,
            ];
            array_push($messages, $message);
        }
        $data  = ['method' => $taskType, 'params' => ['messages' => $messages]];
        $this->sender($data, 'tbot_update_content');
        return $data;
    }

    /**
     * @param InfoSource $channel
     * @return array
     */
    public function searchMessages($channel)
    {
        $taskType  = "searchMessages";
        $data  = ['request' => ['id' => null,'jsonrpc'=> "2.0",'method' => $taskType, 'params' => [
            'channel_id' => $channel->info_source_id,
            'access_hash' => $channel->access_hash,
            'date' => 0,
            'channel_name' => $channel->url,
            'last' => 50,
            'max' => 50,
        ]] ];
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