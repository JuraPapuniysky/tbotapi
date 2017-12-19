<?php
/**
 * Created by PhpStorm.
 * User: jura
 * Date: 19.12.17
 * Time: 23:49
 */

namespace console\models;


use common\models\Worker;

class TestWorker extends Worker
{
    public $body;
    public function work()
    {
        $this->channel->queue_declare('tbot_notification');
        $callback = function($msg) {
            $this->body = $msg->body;
        };
        $this->channel->basic_consume('tbot_notification', '', false, true, false, false, $callback);

        while(count($this->channel->callbacks)) {
            $this->channel->wait();
            print_r($this->body);
        }
    }
}