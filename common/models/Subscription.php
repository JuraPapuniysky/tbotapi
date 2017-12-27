<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subscription".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $project_id
 * @property integer $search_type_id
 * @property string $name
 * @property string $search_expression
 * @property string $notification_periodicity_type
 * @property string $notification_time
 * @property string $notification_mentions_limit
 * @property string $notification_channel
 * @property integer $is_active
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Mention[] $mentions
 * @property Project $project
 * @property SearchType $searchType
 * @property User $user
 * @property UserKeyword[] $userKeywords
 */
class Subscription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscription';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'project_id', 'search_type_id', 'is_active', 'created_at', 'updated_at'], 'integer'],
            [['name', 'search_expression', 'notification_periodicity_type', 'notification_time', 'notification_mentions_limit', 'notification_channel'], 'string', 'max' => 255],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['search_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => SearchType::className(), 'targetAttribute' => ['search_type_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'project_id' => 'Project ID',
            'search_type_id' => 'Search Type ID',
            'name' => 'Name',
            'search_expression' => 'Search Expression',
            'notification_periodicity_type' => 'Notification Periodicity Type',
            'notification_time' => 'Notification Time',
            'notification_mentions_limit' => 'Notification Mentions Limit',
            'notification_channel' => 'Notification Channel',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMentions()
    {
        return $this->hasMany(Mention::className(), ['subscription_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSearchType()
    {
        return $this->hasOne(SearchType::className(), ['id' => 'search_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserKeywords()
    {
        return $this->hasMany(UserKeyword::className(), ['subscription_id' => 'id']);
    }
}
