<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_keyword".
 *
 * @property integer $id
 * @property integer $subscription_id
 * @property string $user_keyword
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Subscription $subscription
 */
class UserKeyword extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_keyword';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subscription_id', 'created_at', 'updated_at'], 'integer'],
            [['user_keyword'], 'string', 'max' => 255],
            [['subscription_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subscription::className(), 'targetAttribute' => ['subscription_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subscription_id' => 'Subscription ID',
            'user_keyword' => 'User Keyword',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscription()
    {
        return $this->hasOne(Subscription::className(), ['id' => 'subscription_id']);
    }
}
