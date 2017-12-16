<?php

use yii\db\Migration;

/**
 * Class m171216_113431_updateinfo2
 */
class m171216_113431_updateinfo2 extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropColumn('{{%info_source}}', 'info_source_type_id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171216_113431_updateinfo2 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171216_113431_updateinfo2 cannot be reverted.\n";

        return false;
    }
    */
}
