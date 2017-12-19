<?php


namespace console\controllers;



use common\models\Worker;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use yii\console\Controller;


class WorkerController extends Controller
{
    public function actionIndex()
    {
           $worker = new Worker();
           $worker->work();
    }
}