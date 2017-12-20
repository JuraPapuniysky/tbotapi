<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\NotFoundHttpException;

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
 * @property integer $info_source_id
 * @property static $access_hash
 *
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
            [['url', 'access_hash'], 'string'],
            [['info_source_id', 'subscribers_quantity', 'indexing_priority', 'last_indexed_date_time', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['info_source_id' => 'id']);
    }

    /**
     * @param $data
     * @return array
     */
    public static function addTelegramChannel($data)
    {
        $urls = explode(',', str_replace(' ', '', $data->urls));
        $models = [];
        $radits = [];
        foreach ($urls as $url){
            if (($model = InfoSource::findOne(['url' => $url])) === null){
                $model = new InfoSource();
                $model->title = $url;
                $model->url = $url;
                $model->subscribers_quantity = 0;

                $model->indexing_priority = 1;
                $model->last_indexed_date_time = null;
                if ($model->save()){
                    array_push($models, $model);
                    $rabbitMQ = new RabbitMQ();
                    $rabbitMQ->indexTelegramChannel($model);
                }else{
                    array_push($models ,$model->save());
                }
            }
        }
        return $models;
    }

    /**
     * @param $data
     * @return null|string|NotFoundHttpException|static
     */
    public static function updateTelegramChannels($channels)
    {
        $s = '';
        foreach ($channels as $channel) {
            if (($model = InfoSource::findOne(['title' => $channel->username])) !== null) {
                $model->title = self::removeEmoji($channel->title);
                $model->url = $channel->username;
                $model->info_source_id = $channel->id;
                $model->access_hash = $channel->access_hash;
                //$model->subscribers_quantity = $channel->subscribers_quantity;
                $model->save();

            }
        }
    }

    public static function removeEmoji($text){
        return preg_replace('/([0-9|#][\x{20E3}])|[\x{00ae}|\x{00a9}|\x{203C}|\x{2047}|\x{2048}|\x{2049}|\x{3030}|\x{303D}|\x{2139}|\x{2122}|\x{3297}|\x{3299}][\x{FE00}-\x{FEFF}]?|[\x{2190}-\x{21FF}][\x{FE00}-\x{FEFF}]?|[\x{2300}-\x{23FF}][\x{FE00}-\x{FEFF}]?|[\x{2460}-\x{24FF}][\x{FE00}-\x{FEFF}]?|[\x{25A0}-\x{25FF}][\x{FE00}-\x{FEFF}]?|[\x{2600}-\x{27BF}][\x{FE00}-\x{FEFF}]?|[\x{2900}-\x{297F}][\x{FE00}-\x{FEFF}]?|[\x{2B00}-\x{2BF0}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F6FF}][\x{FE00}-\x{FEFF}]?/u', '', $text);
    }
}
