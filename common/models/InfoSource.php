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

    /**
     * @param $urls
     * @return array
     */
    public static function addTelegramChannel($urls)
    {
        $models = [];
        foreach ($urls as $url){
            if (($model = InfoSource::findAll(['url' => $url])) !== null){
                $model = new InfoSource();
                $model->title = $url;
                $model->url = $url;
                $model->subscribers_quantity = 0;
                $model->info_source_type_id = 1;
                $model->indexing_priority = 1;
                $model->last_indexed_date_time = null;
                if ($model->save()){
                    array_push($models, $model);
                    // TODO ​ добавить​ ​ в ​ ​ очередь​ ​ задание​ ​ на​ ​ индексацию​ ​ данного канала.
                    /*
                      add_task
                             {
                                task_type:​ ​ "index_telegram_channel";
                                task_data:​ ​ {
                                info_source_id:​ ​ "1";
                                 }
                                 }
                    */
                }else{
                    array_push($models ,$model->save());
                }
            }
        }
        return $models;
    }

    /**
     * @param $post
     * @return null|NotFoundHttpException|static
     */
    public static function updateTelegramChannel($post)
    {
        if (($model = InfoSource::findOne($post['info_source_id'])) !== null) {
            $model->title = $post['title'];
            $model->url = $post['url'];
            $model->subscribers_quantity = $post['subscribers_quantity'];
            if ($model->save()) {
                return $model;
            }else{
                return $model->id.' failed';
            }
        } else {
            return new NotFoundHttpException('info source not found');
        }
    }
}
