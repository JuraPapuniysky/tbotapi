<?php

use yii\db\Migration;

/**
 * Class m171227_194004_change_userkeywords
 */
class m171227_194004_change_userkeywords extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->renameColumn('{{%subscriptions}}', 'user_keywords', 'name');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171227_194004_change_userkeywords cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171227_194004_change_userkeywords cannot be reverted.\n";

        return false;
    }
    */
}
