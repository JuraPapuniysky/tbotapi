<?php
/**
 * Created by PhpStorm.
 * User: wsst17
 * Date: 07.12.17
 * Time: 10:05
 */

namespace frontend\controllers;


use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';
}