<?php

use yii\db\Migration;

/**
 * Class m171226_070635_subscriptions
 */
class m171226_070635_subscriptions extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%user_keyword}}', [
            'id' => $this->primaryKey(),
            'subscription_id' => $this->integer(),
            'user_keyword' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('FK_USER_KEYWORD_SUBSCRIPTION', '{{%user_keyword}}', 'subscription_id');
        $this->addForeignKey('FK_USER_KEYWORD_SUBSCRIPTION', '{{%user_keyword}}', 'subscription_id', 'subscription', 'id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171226_070635_subscriptions cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171226_070635_subscriptions cannot be reverted.\n";

        return false;
    }
    */
}
