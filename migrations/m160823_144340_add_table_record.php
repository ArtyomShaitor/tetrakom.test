<?php

use yii\db\Migration;
use yii\db\Schema;

class m160823_144340_add_table_record extends Migration
{
    private $tableName = 'record';

    private $unicode = ' CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'phone_a' => Schema::TYPE_STRING . $this->unicode,
            'phone_b' => Schema::TYPE_STRING . $this->unicode,
            'begin_date' => Schema::TYPE_TIMESTAMP,
            'connection_date' => Schema::TYPE_TIMESTAMP,
            'finish_date' => Schema::TYPE_TIMESTAMP,
            'direction' => Schema::TYPE_INTEGER,
            'comment' => Schema::TYPE_TEXT . $this->unicode,
        ]);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
        return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
