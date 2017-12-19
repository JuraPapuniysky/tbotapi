<?php


namespace console\models;


use common\models\Worker;
use yii\base\ErrorException;

class TestWorker extends Worker
{
    public $body;
    public function work()
    {
        try {
            $result = ($this->channel->basic_get('tbot_notification', true, null)->body);
        }catch (ErrorException $e){

        }

        print_r($result);
    }
}