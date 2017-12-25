<?php

use yii\db\Migration;

/**
 * Class m171225_055957_index
 */
class m171225_055957_index extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropIndex('FK_SUBSCRIPTION_SEARCH_TYPE', '{{%subscription}}');
        $this->createIndex('FK_SUBSCRIPTION_SEARCH_TYPE', '{{%subscription}}', 'search_type_id');
        $this->addForeignKey('FK_SUBSCRIPTION_SEARCH_TYPE', '{{%subscription}}', 'search_type_id', '{{%search_type}}', 'id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171225_055957_index cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171225_055957_index cannot be reverted.\n";

        return false;
    }
    */
}
