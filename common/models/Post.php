<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\NotFoundHttpException;


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
 * @property integer $chat_message_id
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
            [['info_source_id', 'chat_message_id', 'post_views', 'post_repost_count', 'post_repost_views', 'published_datetime', 'created_at', 'updated_at'], 'integer'],
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

    /**
     * @param $request
     * @return Post|null
     */
    public static function addPost($request)
    {
        foreach ($request->messages as $data) {
            $model = new Post();
            $model->info_source_id = self::getInfoSourceId($data->to_id->channel_id);
            //$model->post_url = $data->media->webpage->url;
            $model->post_data = $data->message;
            $model->post_views = $data->views;
            $model->published_datetime = $data->date;
            $model->infoSource->last_indexed_date_time = $data->date;
            $model->chat_message_id = $data->id;
            $rabbitMQ = new RabbitMQ();
            $rabbitMQ->searchPostForMentions($model);
            return [];
        }
    }

    /**
     * @param $posts
     */
    public static function updatePosts($posts)
    {
        foreach ($posts as $post){
            $dbPosts = Post::findAll(['chat_message_id' => $post->id]);
            foreach ($dbPosts as $dbPost){
                if ($dbPost->infoSource->info_source_id == $post->to_id->channel_id){
                    $dbPost->post_data = $post->message;
                    $dbPost->post_views = $post->views;
                    $dbPost->published_datetime = $post->date;
                    $dbPost->infoSource->last_indexed_date_time = $post->date;
                    $dbPost->chat_message_id = $post->id;
                    $dbPost->save();
                    $dbPost->infoSource;
                }
            }
        }
    }

    public static function getInfoSourceId($channel_id)
    {
        if (($model = InfoSource::findOne(['info_source_id' => $channel_id])) !== null){
            return $model->id;
        }else{
            throw new NotFoundHttpException('info_source_not found with id ' . $channel_id);
        }
    }

    /**
     * @param $data
     * @return array
     */
    public static function updatePostsViews($data)
    {
        $models = [];
        foreach ($data->posts as $post){
            if (($model = Post::findOne($post->id)) !== null){
                $model->post_views = $post->views;
                if($model->save()){
                    array_push($models, $model);
                }
            }
        }
        return $models;
    }

    public static function savePost($data)
    {
        $model = new Post();
        $model->info_source_id = $data->info_source_id;
        $model->post_url = $data->post_url;
        $model->post_data = json_encode($data->post_data); // InfoSource::removeEmoji($data->post_data); //$data->post_data;
        $model->post_views = $data->post_views;
        $model->published_datetime = $data->published_datetime;
        //$model->infoSource->last_indexed_date_time = time();
        $model->chat_message_id = $data->chat_message_id;
        if ($model->save()){
            return $model->id;
        }else{
            return false;
        }
    }


}
