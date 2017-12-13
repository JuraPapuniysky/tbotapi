<?php

use yii\db\Migration;

/**
 * Class m171213_202709_update_user
 */
class m171213_202709_update_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%scrapper}}', [
           'id' => $this->primaryKey(),
           'uuid4' => $this->string(128),
           'access_hash' => $this->string(32),
           'created_at' => $this->integer(),
           'updated_at' => $this->integer(),
        ]);

        $this->addColumn('{{%user}}', 'uuid4', $this->string(128));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171213_202709_update_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171213_202709_update_user cannot be reverted.\n";

        return false;
    }
    */
}
