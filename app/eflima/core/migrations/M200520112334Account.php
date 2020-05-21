<?php

namespace eflima\core\migrations;

use yii\db\Migration;

/**
 * Class M200520112334Account
 */
class M200520112334Account extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%account}}', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'uuid' => $this->char(36)->unique()->notNull(),
            'username' => $this->string(255)->null(),
            'email' => $this->string(255)->null(),
            'phone' => $this->text()->null(),
            'type' => $this->string(64)->notNull(),
            'password' => $this->text()->null(),
            'pasword_reset_token' => $this->char(64)->null(),
            'pasword_reset_token_expiration' => $this->integer()->unsigned()->null(),
            'auth_token' => $this->char(64)->notNull(),
            'is_blocked' => $this->boolean()->defaultValue(false)->unsigned(),
            'is_system' => $this->boolean()->defaultValue(false)->unsigned(),
            'confirmation_token' => $this->char(64)->null(),
            'confirmation_expiration' => $this->integer()->unsigned()->null(),
            'confirmed_at' => $this->integer()->unsigned()->null(),
            'last_active_at' => $this->integer()->unsigned(),
            'created_at' => $this->integer()->unsigned(),
            'updated_at' => $this->integer()->unsigned(),
        ], $tableOptions);

        $this->createTable('{{%account_vendor_auth}}', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'account_id' => $this->integer()->unsigned()->notNull(),
            'vendor' => $this->string(32)->notNull(),
            'access_token' => $this->text()->notNull(),
            'data' => $this->text()->null(),
            'expiration' => $this->integer()->unsigned()->null(),
            'created_at' => $this->integer()->unsigned(),
        ], $tableOptions);


        $this->addForeignKey(
            'account_of_vendor_auth',
            '{{%account_vendor_auth}}', 'account_id',
            '{{%account}}', 'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('account_of_vendor_auth', '{{%account_vendor_auth}}');

        $this->dropTable('{{%account}}');
        $this->dropTable('{{%account_vendor_auth}}');
    }
}
