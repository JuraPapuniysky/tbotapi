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
        $this->addColumn('{{%user}}', 'is_approved');
        $this->createTable('{{%project}}', [
            'id' => $this->primarKey(),
            'title' => $this->text(),
            'user_id' => $this->integer(),
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
