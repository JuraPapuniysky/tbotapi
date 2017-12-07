<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Exception;

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

    public static function addPost($post)
    {
        $model = new Post();
        $model->info_source_id = $post['info_source_id'];
        $model->post_url = $post['post_url'];
        $model->post_data = $post['post_data'];
        $model->post_views = $post['post_views'];
        $model->published_datetime = Yii::$app->formatter->asTimestamp($post['published_datetime'], 'dd.mm.yyyy H:i');
        if ($model->save()){
            $model->infoSource->last_indexed_date_time = $model->published_datetime;
            // TODO Также,​ ​ метод​ ​ добавляет​ ​ в ​ ​ очередь​ ​ задание​ ​ на​ ​ поиск​ ​ упоминаний​ ​ вданном​ ​ посте.
            /*
                 add_task
                        {
                            task_type:​ ​ "search_post_for_mentions";
                            task_data:​ ​ {
                                        post_id:​ ​ "1";
                                     }
                         }
             */
            return $model;
        }else{
            throw new Exception('the post with info_source_id = '. $model->info_source_id .' not added');
        }
    }
}
