<?php


namespace frontend\controllers;


use common\models\Error;
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
    public function actionUpdateChannels()
    {
        $data = self::jsonDecoder();
        if (Scrapper::isScrapper($data->id, $data->access_hash) !== false){
            return InfoSource::updateTelegramChannel($data);
        }
    }


    public function actionAddPost()
    {
        $data = self::jsonDecoder();
        if (Scrapper::isScrapper($data->id, $data->access_hash) !== false) {
            return Post::addPost(self::jsonDecoder());
        }
    }

    public function actionUpdatePosts()
    {
        $data = self::jsonDecoder();
        if (Scrapper::isScrapper($data->id, $data->access_hash) !== false){
            return Post::updatePosts($data->messages);
        }
    }

    /**
     * @return array
     */
    public function actionUpdatePostsViews()
    {
        $data = self::jsonDecoder();
       // if (Scrapper::isScrapper($data->id, $data->access_hash) !== false) {
            return Post::updatePostsViews($data);
      //  }
    }

    /**
     * Generates a code for authenticate on the server
     * @return string
     */
    public function actionInitScrapper()
    {
        $data = self::jsonDecoder();
        if (($scrapper = Scrapper::findOne(['uuid4' => $data->id])) !== null){
            $scrapper->generateAccessCode();
            if($scrapper->save()){
                return $scrapper->access_hash;
            }
        } else{
            return new Error(0, 'Error Scrapper with uuid4'.$data->id.'not found');
        }

    }

    /**
     * @return array|Error
     */
    public function actionActivateScrapper()
    {
        $data = self::jsonDecoder();
        if (($scrapper = Scrapper::findOne(['uuid4' => $data->id])) !== null){
            if ($data->access_hash === $scrapper->access_hash && $data->access_code === $scrapper->access_code){
                return $scrapper->activateScrapper();
            }else{
                return new Error(0, 'Error hash or code is not correct');
            }
        }else{
            return new Error(0, 'Scrapper not found');
        }
    }

    /**
     * @return Error
     */
    public function actionDeactivateScrapper()
    {
        $data = self::jsonDecoder();
        $scrapper = Scrapper::isScrapper($data->id, $data->access_hash);
        if ($scrapper !== false){
            $scrapper->removeAccessCode();
            $scrapper->save();
        }else{
            return new Error(0, 'Scrapper not found');
        }
    }

    public function actionGetAccounts()
    {
        $data = self::jsonDecoder();
        if (($scrapper = Scrapper::isScrapper($data->id, $data->access_hash)) !== false){
            return ['id' => $data->id, 'accounts' => $scrapper->updateAccounts($data->accounts), "cleanup" => true];
        }else{
            return new Error(0, 'Scrapper not found');
        }
    }


    public function getTask()
    {

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

    public function actionGetTask()
    {

    }
}