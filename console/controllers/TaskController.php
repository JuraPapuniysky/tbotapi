<?php


namespace console\controllers;


use common\models\InfoSource;
use common\models\Post;
use common\models\RabbitMQ;
use yii\console\Controller;

class TaskController extends  Controller
{
    public function actionIndex()
    {

    }

    public function actionChannelsUpdateTask()
    {
        if (($models = InfoSource::find()->andWhere(['<', 'last_indexed_date_time', time()-3600*24])
                ->andWhere([ 'last_indexed_date_time' => null])->all()) !== null){
            $rabbitMQ = new RabbitMQ();
            foreach ($models as $model){
                $rabbitMQ->updateChannel($model);
            }
        }
    }

    public function actionMessageUpdateTask()
    {
        if (($models = Post::find()->andWhere(['<', 'updated_at', time()-3600*24])) !== null){
            $rabbitMQ = new RabbitMQ();
            foreach ($models as $model){
                $rabbitMQ->updatePost($model);
            }
        }
    }
}