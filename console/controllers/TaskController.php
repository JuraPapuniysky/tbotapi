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

    public function actionSearchChannels()
    {
        $rabbitMQ = new RabbitMQ();
        $rabbitMQ->searchChannels();
    }

    public function actionSearchMessages()
    {
        $models = InfoSource::find()->all();

        foreach ($models as $model){
            $rabbitMQ = new RabbitMQ();
            $rabbitMQ->searchMessages($model);
        }

    }

    public function actionChannelsUpdateTask()
    {
        if (($models = InfoSource::find()->andWhere(['<', 'last_indexed_date_time', time()-3600*24])
                ->andWhere([ 'last_indexed_date_time' => null])->all()) !== null){

            foreach ($models as $model){
                $rabbitMQ = new RabbitMQ();
                $rabbitMQ->updateChannel($model);
            }
        }
    }

    public function actionUpdateMessages()
    {
        //if (($models = Post::find()->andWhere(['<', 'updated_at', time()-3600*24])) !== null){
        if (($models = Post::find()->andWhere(['<', 'updated_at', time()])->all()) !== null){
            $rabbitMQ = new RabbitMQ();

            $rabbitMQ->updatePost($models);

        }
    }
}