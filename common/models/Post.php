<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property integer $info_source_id
 * @property string $post_url
 * @property string $post_data
 * @property integer $post_views
 * @property integer $post_repost_count
 * @property integer $post_repost_views
 * @property integer $published_datetime
 * @property string $author
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Mention[] $mentions
 * @property InfoSource $infoSource
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['info_source_id', 'post_views', 'post_repost_count', 'post_repost_views', 'published_datetime', 'created_at', 'updated_at'], 'integer'],
            [['post_data'], 'string'],
            [['post_url', 'author'], 'string', 'max' => 255],
            [['info_source_id'], 'exist', 'skipOnError' => true, 'targetClass' => InfoSource::className(), 'targetAttribute' => ['info_source_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'info_source_id' => 'Info Source ID',
            'post_url' => 'Post Url',
            'post_data' => 'Post Data',
            'post_views' => 'Post Views',
            'post_repost_count' => 'Post Repost Count',
            'post_repost_views' => 'Post Repost Views',
            'published_datetime' => 'Published Datetime',
            'author' => 'Author',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMentions()
    {
        return $this->hasMany(Mention::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInfoSource()
    {
        return $this->hasOne(InfoSource::className(), ['id' => 'info_source_id']);
    }
}
