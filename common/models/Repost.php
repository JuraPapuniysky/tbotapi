<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "repost".
 *
 * @property integer $id
 * @property integer $mention_id
 * @property string $repost_url
 * @property integer $published_datetime
 * @property string $author
 * @property integer $repost_vievs
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Mention $mention
 */
class Repost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'repost';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mention_id', 'published_datetime', 'repost_vievs', 'created_at', 'updated_at'], 'integer'],
            [['repost_url', 'author'], 'string', 'max' => 255],
            [['mention_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mention::className(), 'targetAttribute' => ['mention_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mention_id' => 'Mention ID',
            'repost_url' => 'Repost Url',
            'published_datetime' => 'Published Datetime',
            'author' => 'Author',
            'repost_vievs' => 'Repost Vievs',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMention()
    {
        return $this->hasOne(Mention::className(), ['id' => 'mention_id']);
    }
}
