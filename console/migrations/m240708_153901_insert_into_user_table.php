<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m240708_153901_insert_into_user_table
 */
class m240708_153901_insert_into_user_table extends Migration
{
    private $tableName = "{{%user}}";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert($this->tableName, [
            'username' => 'admin',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash(123456),
            'email' => 'admin@admin.ru',
            'status' => User::STATUS_ACTIVE,
            'created_at' => time(),
            'updated_at' => time(),
            'access_token' => "123456",
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete($this->tableName, ['email' => "admin@admin.ru"]);
    }
}
