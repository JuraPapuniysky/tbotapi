<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "account".
 *
 * @property integer $id
 * @property integer $scrapper_id
 * @property string $phoneNumber
 * @property integer $is_active
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Scrapper $scrapper
 */
class Account extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['scrapper_id', 'is_active', 'created_at', 'updated_at'], 'integer'],
            [['phoneNumber'], 'string', 'max' => 32],
            [['scrapper_id'], 'exist', 'skipOnError' => true, 'targetClass' => Scrapper::className(), 'targetAttribute' => ['scrapper_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'scrapper_id' => 'Scrapper ID',
            'phoneNumber' => 'Phone Number',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScrapper()
    {
        return $this->hasOne(Scrapper::className(), ['id' => 'scrapper_id']);
    }
}
