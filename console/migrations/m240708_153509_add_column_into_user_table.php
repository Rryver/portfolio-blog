<?php

use yii\db\Migration;

/**
 * Class m240708_153509_add_column_into_user_table
 */
class m240708_153509_add_column_into_user_table extends Migration
{
    private $tableName = "{{%user}}";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, "access_token", $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, "access_token");
    }
}
