<?php


namespace common\models;


use PhpAmqpLib\Connection\AMQPStreamConnection;
use yii\base\ErrorException;

/**
 * Class Worker
 * @package app\models
 * @property Subscription[] $subscriptions;
 * @property UserKeyword[] $userKeywords;
 */
class Worker
{
    public $subscriptions;
    public $userKeywords;
    public $connection;
    public $channel;
    public $updateTime;

    public function __construct()
    {
       // $this->subscriptions = Subscription::find()->all();
        $this->userKeywords = UserKeyword::find()->all();
        $this->updateTime = time();
        $this->connection = new AMQPStreamConnection('185.16.42.168', 5672, 'tbot', 'ASDFwEWEW');
        $this->channel = $this->connection->channel();
    }

    public function work()
    {
        $this->channel->queue_declare('tbot_message_analyze');
        $callback = function($msg) {
            $this->updateSubscriptions();
            $this->search($msg);
            echo $msg->body.' '.$this->hello()."\n";
        };
        $this->channel->basic_consume('tbot_message_analyze', '', false, true, false, false, $callback);

        while(count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }

    private function hello()
    {
        return 'Is done';
    }

    /**
     * @param $msg
     */
    private function search($msg)
    {
        $task = json_decode($msg->body);
        if ($task->task_type == 'search_post_for_mentions'){
            foreach ($this->userKeywords as $userKeyword) {
                echo $userKeyword->user_keyword. "\n";
                $searchEngine = new SearchEngine();
                $index = $searchEngine->makeIndex($task->task_data->post->post_data);
                $result = $searchEngine->search($searchEngine->makeIndex($userKeyword->user_keyword), $index);
                echo $result."\n";
                if ($result > 0){
                    $postId = Post::savePost($task->task_data->post);
                   if ($postId !== false){
                       $mention = Mention::createNewMention($userKeyword->subscription_id, $postId);
                       $rabbitMQ = new RabbitMQ();
                       $rabbitMQ->sendMention($mention->id);
                   }

                }
            }
        }
    }


    private function updateSubscriptions()
    {
        if ($this->updateTime + 300 <= time()){
            $lastCreated = $this->userKeywords[count($this->userKeywords) - 1]->created_at;
            $newUserKeywords = UserKeyword::findAll('created_at' > $lastCreated);
            if (count($newUserKeywords) > 0){
                foreach ($newUserKeywords as $newUserKeyword){
                    array_push($this->userKeywords, $newUserKeyword);
                }
            }
            $this->updateTime = time();
        }
    }

    public function sendTask()
    {
        try {
            return ($this->channel->basic_get('tbot_update_content', true, null)->body);
        }catch (ErrorException $e){
            return null;
        }
    }
}