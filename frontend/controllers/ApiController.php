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
        $modelsAdded = InfoSource::addTelegramChannel(self::jsonDecoder());
        return $modelsAdded;
    }


    /**
     * @return null|\yii\web\NotFoundHttpException|static
     */
    public function actionUpdateInfoSource()
    {
       return InfoSource::updateTelegramChannel(self::jsonDecoder());
    }


    public function actionAddPost()
    {
        return Post::addPost(self::jsonDecoder());
    }

    public function actionUpdatePostsViews()
    {
        return Post::updatePostsViews(self::jsonDecoder());
    }

    public function actionTest()
    {

        $a = self::jsonDecoder();
        return $a;
       // return Post::find()->all();
    }



    /**
     * @return mixed
     */
    protected static function jsonDecoder()
    {
        return json_decode(file_get_contents("php://input"));
    }
}