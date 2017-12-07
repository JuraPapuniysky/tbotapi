<?php


namespace frontend\controllers;


use common\models\InfoSource;
use common\models\Post;
use yii\rest\ActiveController;

class ApiController extends ActiveController
{
    public $modelClass = 'common\models\InfoSources';

    /**
     * @return array
     */
    public function actionAddTelegramChannels()
    {
        $urls = explode(', ', \Yii::$app->request->post('urls'));
        $modelsAdded = InfoSource::addTelegramChannel($urls);
        return $modelsAdded;
    }


    public function actionUpdateInfoSource()
    {
       return InfoSource::updateTelegramChannel(\Yii::$app->request->post());
    }

    public function actionAddPost()
    {
        $post = \Yii::$app->request->post();
        Post::addPost($post);
    }
}