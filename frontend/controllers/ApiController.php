<?php


namespace frontend\controllers;


use common\models\InfoSource;
use common\models\Post;
use common\models\Scrapper;
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

    /**
     * @return array
     */
    public function actionUpdatePostsViews()
    {
        return Post::updatePostsViews(self::jsonDecoder());
    }

    /**
     * Generates a code for authenticate on the server
     * @return string
     */
    public function actionInitScrapper()
    {
        $data = self::jsonDecoder();
        if (($scrapper = Scrapper::findOne(['uuid4' => $data->id])) !== null){
            $scrapper->generateAccessHash();
            if($scrapper->save()){
                return $scrapper->access_hash;
            }
        } else{
            return 'Error Scrapper with uuid4'.$data->id.'not found.';
        }
    }

    /**
     * @return mixed
     */
    protected static function jsonDecoder()
    {
        return json_decode(file_get_contents("php://input"));
    }


    public function actionTest()
    {

        $a = self::jsonDecoder();
        return $a;
        // return Post::find()->all();
    }
}