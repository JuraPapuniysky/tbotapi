<?php

use yii\db\Migration;

/**
 * Class m171216_113052_updateinfo
 */
class m171216_113052_updateinfo extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropForeignKey("FK_INFO_SOURCE_TYPE", '{{%info_source}}');
        $this->dropIndex("FK_INFO_SOURCE_TYPE", '{{%info_source}}');
        $this->dropTable('{{%info_source_type}}');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171216_113052_updateinfo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171216_113052_updateinfo cannot be reverted.\n";

        return false;
    }
    */
}
