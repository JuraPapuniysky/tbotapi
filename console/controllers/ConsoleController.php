<?php
/**
 * Created by PhpStorm.
 * User: jura
 * Date: 15.12.17
 * Time: 19:13
 */

namespace console\controllers;


use common\models\InfoSource;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionIndex()
    {
        foreach (file(__DIR__ . '/channels.txt') as $channel){
            $info_source = new InfoSource();
            $info_source->title = $channel;
            $info_source->save();
        }
    }

    public function actionTrim()
    {
       foreach (InfoSource::find()->all() as $infoSource){
           $infoSource->title = trim($infoSource->title);
           $infoSource->save();
       }
    }
}