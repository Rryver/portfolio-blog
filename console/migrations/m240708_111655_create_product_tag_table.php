<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_tag}}`.
 */
class m240708_111655_create_product_tag_table extends Migration
{
    private $tableName = '{{%product_tag}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-product_tag-tag_id-product-id',
            $this->tableName,
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-product_tag-tag_id-tag-id',
            $this->tableName,
            'tag_id',
            '{{%tag}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            "INDEX-product_tag-product_id-tag_id",
            $this->tableName,
            ['product_id', 'tag_id'],
            true
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
