<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m240708_111602_create_category_table extends Migration
{
    private $tableName = '{{%category}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'title' => $this->string()->notNull(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'is_deleted' => $this->boolean()->notNull()->defaultValue(false),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey(
            "FK-category-parent_id-category-id",
            $this->tableName,
            "parent_id",
            "{{%category}}",
            "id",
            "CASCADE",
            "CASCADE"
        );

        $this->createIndex(
            "INDEX-category-title",
            $this->tableName,
            "title"
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
