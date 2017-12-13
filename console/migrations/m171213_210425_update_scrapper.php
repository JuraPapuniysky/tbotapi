<?php

use yii\db\Migration;

/**
 * Class m171213_210425_update_scrapper
 */
class m171213_210425_update_scrapper extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropColumn('{{%scrapper}}', 'access_hash');
        $this->addColumn('{{%scrapper}}', 'access_hash', $this->string(128));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171213_210425_update_scrapper cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171213_210425_update_scrapper cannot be reverted.\n";

        return false;
    }
    */
}
