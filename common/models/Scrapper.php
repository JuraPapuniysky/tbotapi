<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "scrapper".
 *
 * @property integer $id
 * @property string $uuid4
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $access_hash
 * @property integer $api_id
 * @property string $api_hash
 * @property string $access_code
 *
 * @property Account[] $accounts
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

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'api_id'], 'integer'],
            [['uuid4', 'access_hash', 'api_hash'], 'string', 'max' => 128],
            [['access_code'], 'string', 'max' => 32],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'access_hash' => 'Access Hash',
            'api_id' => 'Api ID',
            'api_hash' => 'Api Hash',
            'access_code' => 'Access Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccounts()
    {
        return $this->hasMany(Account::className(), ['scrapper_id' => 'id']);
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
    public static function isScrapper($uuid4, $access_hash = null)
    {
        if (($model = Scrapper::findOne(['uuid4' => $uuid4])) !== null){
            //if ($model->access_hash === $access_hash){
                return $model;
            //}else{
            //    return false;
           // }
        }else{
            return false;
        }
    }

    public function updateAccounts($accounts)
    {
        foreach ($accounts as $account){
            if (($dbAccount = Account::findOne(['phone_number' => $account->phoneNumber, 'scrapper_id' => $this->id])) !== null){
               if ($account->isActive == true) {
                   $dbAccount->is_active = 1;
               }else{
                   $dbAccount->is_active = 0;
               }
                $dbAccount->save();
            }else{
                $dbAccount = new Account();
                $dbAccount->phoneNumber = $account->phoneNumber;
                if ($account->isActive == true) {
                    $dbAccount->is_active = 1;
                }else{
                    $dbAccount->is_active = 0;
                }
                $dbAccount->scrapper_id = $this->id;
                $dbAccount->save();
            }
        }

        return Account::findAll(['scrapper_id' => $this->id, 'is_active' => 0]);
    }
}
