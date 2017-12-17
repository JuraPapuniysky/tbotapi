<?php

use yii\db\Migration;

/**
 * Class m171217_044220_message_id
 */
class m171217_044220_message_id extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%post}}', 'chat_message_id', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171217_044220_message_id cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171217_044220_message_id cannot be reverted.\n";

        return false;
    }
    */
}
