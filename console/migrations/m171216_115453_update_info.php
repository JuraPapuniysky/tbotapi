<?php

use yii\db\Migration;

/**
 * Class m171216_115453_update_info
 */
class m171216_115453_update_info extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%info_source}}', 'info_source_id', $this->integer());
        $this->addColumn('{{%info_source}}', 'access_hash', $this->string(128));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171216_115453_update_info cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171216_115453_update_info cannot be reverted.\n";

        return false;
    }
    */
}
