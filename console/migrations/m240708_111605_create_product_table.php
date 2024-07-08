<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m240708_111605_create_product_table extends Migration
{
    private $tableName = '{{%product}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'price' => $this->double(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'is_deleted' => $this->boolean()->notNull()->defaultValue(false),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey(
            "FK-product-category_id-category-id",
            $this->tableName,
            "category_id",
            "{{%category}}",
            "id",
            "CASCADE",
            "CASCADE"
        );

        $this->createIndex(
            "INDEX-product-title",
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
