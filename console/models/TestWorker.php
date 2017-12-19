<?php


namespace console\models;


use common\models\Worker;

class TestWorker extends Worker
{
    public $body;
    public function work()
    {
        $result = ($this->channel->basic_get('tbot_notification', true, null)->body);
        print_r($result);
    }
}