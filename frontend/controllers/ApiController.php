<?php


namespace frontend\controllers;


use common\models\Error;
use common\models\InfoSource;
use common\models\Post;
use common\models\Scrapper;
use common\models\Worker;
use yii\rest\ActiveController;


class ApiController extends ActiveController
{

    public $modelClass = 'common\models\InfoSources';

    /**
     * Adds telegram info source to db. (channels, chats, ...)
     * @return array
     */
    public function actionAddTelegramChannels()
    {
        $modelsAdded = InfoSource::addTelegramChannel(self::jsonDecoder()->channels);
        return $modelsAdded;
    }


    /**
     * Updates data id saved telegram info source.
     * @return null|\yii\web\NotFoundHttpException|static
     */
    public function actionUpdateChannels()
    {
        $data = self::jsonDecoder();
       // if (Scrapper::isScrapper($data->id, $data->access_hash) !== false){
           return InfoSource::updateTelegramChannels($data->channels);
       // }
        //return InfoSource::findOne(['title' => $data[0]->username]);
    }


    /**
     * Add posts to db
     * @return Post|null
     */
    public function actionAddPost()
    {
        return Post::addPost(self::jsonDecoder());
        //return self::jsonDecoder()[0];
    }

    /**
     *
     */
    public function actionUpdatePosts()
    {
        $data = self::jsonDecoder();
       // if (Scrapper::isScrapper($data->id, $data->access_hash) !== false){
            return Post::updatePosts($data->messages);
       // }
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

    /**
     * @return array|Error
     */
    public function actionGetAccounts()
    {

        $data = self::jsonDecoder();
       // if (()) !== false){
        $scrapper = Scrapper::isScrapper($data->id);
            $accounts = [];
            foreach ($scrapper->accounts as $account){
                if($account->is_active == 1){
                    $isActive = true;
                }else{
                    $isActive = false;
                }

                $saccount = ['phoneNumber' => $account->phoneNumber, 'isActive' => $isActive];
                array_push($accounts, $saccount);
            }
            return ['cleanup' => false, 'accounts' => $accounts];
        //}else{
        //    return new Error(0, 'Scrapper not found');
       // }

        //return ['cleanup' => false, 'accounts' => [['phoneNumber' => '380935635959', 'isActive' => true]]];
    }

    /**
     * @return null
     */
    public function actionGetTask()
    {
        $worker = new Worker();
        if($worker->sendTask() !== null){
            return json_decode($worker->sendTask());
        }else{
            return ['timeout' => 10, 'request' => null];
        }

    }

    /**
     * @return null
     */
    public function actionTaskDone()
    {
        return [];
    }

    public function actionTest()
    {
        return self::jsonDecoder()->channels[0];
    }

    /**
     * @return mixed
     */
    protected static function jsonDecoder()
    {
        return json_decode(file_get_contents("php://input"));
    }
}