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
            [['created_at', 'updated_at'], 'integer'],
            [['uuid4', 'access_hash'], 'string', 'max' => 128],
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

    public function generateAccessHash()
    {
        $this->access_hash = Yii::$app->uuid->uuid4();
    }

    public function removeAccessHash()
    {
        $this->access_hash = null;
    }
}
