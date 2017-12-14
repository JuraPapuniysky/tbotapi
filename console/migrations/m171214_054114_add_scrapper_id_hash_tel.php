<?php

use yii\db\Migration;

/**
 * Class m171214_054114_add_scrapper_id_hash_tel
 */
class m171214_054114_add_scrapper_id_hash_tel extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%scrapper}}', 'api_id', $this->integer());
        $this->addColumn('{{%scrapper}}', 'api_hash', $this->string(128));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171214_054114_add_scrapper_id_hash_tel cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171214_054114_add_scrapper_id_hash_tel cannot be reverted.\n";

        return false;
    }
    */
}
