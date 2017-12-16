<?php

use yii\db\Migration;

/**
 * Class m171214_093836_account
 */
class m171214_093836_account extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%account}}', [
            'id' => $this->primaryKey(),
            'scrapper_id'=> $this->integer(),
            'phoneNumber' => $this->string(32),
            'is_active' => $this->boolean(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->createIndex('FK_SCRAPPER_ACCOUNT', '{{%account}}', 'scrapper_id');

        $this->addForeignKey('FK_SCRAPPER_ACCOUNT', '{{%account}}', 'scrapper_id', '{{%scrapper}}', 'id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171214_093836_account cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171214_093836_account cannot be reverted.\n";

        return false;
    }
    */
}
