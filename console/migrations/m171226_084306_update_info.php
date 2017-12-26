<?php

use yii\db\Migration;

/**
 * Class m171226_084306_update_info
 */
class m171226_084306_update_info extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->alterColumn('{{%info_source}}', 'url', $this->string()->unique());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171226_084306_update_info cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171226_084306_update_info cannot be reverted.\n";

        return false;
    }
    */
}
