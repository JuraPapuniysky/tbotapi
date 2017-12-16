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
        $result = file(__DIR__ . '/channels.txt');
       // print_r($result);

        for ($i = 0; $i <= count($result); $i++)
        {
            $model = new InfoSource();
            $model->title = $result[$i];
            $model->url = $result[$i];
            $model->subscribers_quantity = 0;
            $model->info_source_type_id = 1;
            $model->indexing_priority = 1;
            $model->last_indexed_date_time = null;
            if($model->save()){
                echo "Filed";
            }
            $i++;
        }
    }
}