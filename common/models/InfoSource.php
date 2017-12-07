<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "info_source".
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property integer $subscribers_quantity
 * @property integer $info_source_type_id
 * @property integer $indexing_priority
 * @property integer $last_indexed_date_time
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property InfoSourceType $infoSourceType
 * @property Post[] $posts
 */
class InfoSource extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'info_source';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url'], 'string'],
            [['subscribers_quantity', 'info_source_type_id', 'indexing_priority', 'last_indexed_date_time', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['info_source_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => InfoSourceType::className(), 'targetAttribute' => ['info_source_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'url' => 'Url',
            'subscribers_quantity' => 'Subscribers Quantity',
            'info_source_type_id' => 'Info Source Type ID',
            'indexing_priority' => 'Indexing Priority',
            'last_indexed_date_time' => 'Last Indexed Date Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInfoSourceType()
    {
        return $this->hasOne(InfoSourceType::className(), ['id' => 'info_source_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['info_source_id' => 'id']);
    }
}
