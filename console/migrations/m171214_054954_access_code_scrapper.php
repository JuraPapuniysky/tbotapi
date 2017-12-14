<?php

use yii\db\Migration;

/**
 * Class m171214_054954_access_code_scrapper
 */
class m171214_054954_access_code_scrapper extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%scrapper}}', 'access_code', $this->string(32));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171214_054954_access_code_scrapper cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171214_054954_access_code_scrapper cannot be reverted.\n";

        return false;
    }
    */
}
