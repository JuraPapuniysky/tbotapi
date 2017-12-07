<?php

use yii\db\Migration;

/**
 * Class m171206_212204_init
 */
class m171206_212204_init extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'first_name', $this->string(255));
        $this->addColumn('{{%user}}', 'second_name', $this->string(255));
        $this->addColumn('{{%user}}', 'is_approved', $this->boolean());

        $this->createTable('{{%project}}', [
            'id' => $this->primaryKey(),
            'title' => $this->text(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('{{%subscription}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'project_id' => $this->integer(),
            'search_type_id' => $this->integer(),
            'user_keywords' => $this->string(255),
            'search_expression' => $this->string(255),
            'notification_periodicity_type' => $this->string(255),
            'notification_time' => $this->string(255),
            'notification_mentions_limit' => $this->string(),
            'notification_channel' => $this->string(255),
            'is_active' => $this->boolean(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('{{%search_type}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);


        $this->createIndex('FK_USERS_PROJECT', '{{%project}}', 'user_id');
        $this->addForeignKey('FK_USERS_PROJECT', '{{%project}}',
            'user_id', '{{%user}}', 'id');

        $this->createIndex('FK_SUBSCRIPTION_USER', '{{%subscription}}', 'user_id');
        $this->addForeignKey('FK_SUBSCRIPTION_USER', '{{%subscription}}', 'user_id', '{{%user}}', 'id');

        $this->createIndex('FK_SUBSCRIPTION_PROJECT', '{{%subscription}}', 'project_id');
        $this->addForeignKey('FK_SUBSCRIPTION_PROJECT', '{{%subscription}}', 'project_id', '{{%project}}', 'id');

        $this->createIndex('FK_SUBSCRIPTION_SEARCH_TYPE', '{{%subscription}}', 'search_type_id', '{{%search_type}}', 'id');


        $this->createTable('{{%info_source}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'url' => $this->text(),
            'subscribers_quantity' => $this->integer(),
            'info_source_type_id' => $this->integer(),
            'indexing_priority' => $this->integer(),
            'last_indexed_date_time' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);


        $this->createTable('{{%info_source_type}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('FK_INFO_SOURCE_TYPE', '{{%info_source}}', 'info_source_type_id');
        $this->addForeignKey('FK_INFO_SOURCE_TYPE', '{{%info_source}}', 'info_source_type_id', '{{%info_source_type}}', 'id');

        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'info_source_id' => $this->integer(),
            'post_url' => $this->string(255),
            'post_data' => $this->text(),
            'post_views' => $this->integer(),
            'post_repost_count' => $this->integer(),
            'post_repost_views' => $this->integer(),
            'published_datetime' => $this->integer(),
            'author' => $this->string(255),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('FK_INFO_SOURCE_POST', '{{%post}}', 'info_source_id');
        $this->addForeignKey('FK_INFO_SOURCE_POST', '{{%post}}', 'info_source_id', '{{%info_source}}', 'id');

        $this->createTable('{{%mention}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'subscription_id' => $this->integer(),
            'is_notified' => $this->boolean(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('FK_POST_MENTION', '{{%mention}}', 'post_id');
        $this->addForeignKey('FK_POST_MENTION', '{{%mention}}', 'post_id', '{{%post}}', 'id');

        $this->createIndex('FK_MENTION_SUBSCRIPTION', '{{%mention}}', 'subscription_id');
        $this->addForeignKey('FK_MENTION_SUBSCRIPTION', '{{%mention}}', 'subscription_id', '{{%subscription}}', 'id');

        $this->createTable('{{%repost}}', [
            'id' => $this->primaryKey(),
            'mention_id' => $this->integer(),
            'repost_url' => $this->string(),
            'published_datetime' => $this->integer(),
            'author' => $this->string(),
            'repost_vievs' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('FK_MENTION_REPOST', '{{%repost}}', 'mention_id');
        $this->addForeignKey('FK_MENTION_REPOST', '{{%repost}}', 'mention_id', '{{%mention}}', 'id');


        $this->insert('{{%user}}', [
            'username' => 'admin',
            'auth_key' => '0S3JJ57hkMu_sGaWZyOb5_QNJEyxVIEz',
            'password_hash' => '$2y$13$PTN.QlaN4XjCAM6MsNarxOXRwW0Ram2vDbTK3/C5PxZTrM2x3/on2',
            'email' => 'mail@mail.com',
            'status' => 10,
            'created_at' => 1,
            'updated_at' => 1,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171206_212204_init cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171206_212204_init cannot be reverted.\n";

        return false;
    }
    */
}
