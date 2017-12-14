<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "scrapper".
 *
 * @property integer $id
 * @property string $uuid4
 * @property string $access_hash
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $api_id
 * @property string $api_hash
 * @property string $access_code
 */
class Scrapper extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'scrapper';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'api_id',], 'integer'],
            [['uuid4', 'access_hash', 'api_hash',], 'string', 'max' => 128],
            [['access_code'], 'string', 'max' => 32],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uuid4' => 'Uuid4',
            'access_hash' => 'Access Hash',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function generateAccessCode()
    {
        $this->access_code = Yii::$app->security->generateRandomString();
    }

    public function removeAccessCode()
    {
        $this->access_code = null;
    }

    public function activateScrapper()
    {
        return ["api_id" => $this->api_id, "api_hash" => $this->api_hash];
    }


    /**
     * @param $uuid4
     * @param $access_hash
     * @return bool|null|static
     */
    public static function isScrapper($uuid4, $access_hash)
    {
        if (($model = Scrapper::findOne(['uuid4' => $uuid4])) !== null){
            if ($model->access_hash === $access_hash){
                return $model;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

}
