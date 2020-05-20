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
            'id' => $this->char(16)->notNull(),
            'username' => $this->string(255)->null(),
            'email' => $this->string(255)->null(),
            'phone' => $this->text()->null(),
            'password' => $this->text()->null(),
            'pasword_reset_token' => $this->char(64)->null(),
            'pasword_reset_token_expiration' => $this->integer()->unsigned()->null(),
            'auth_token' => $this->char(64),
            'is_blocked' => $this->boolean()->defaultValue(false)->unsigned(),
            'is_system' => $this->boolean()->defaultValue(false)->unsigned(),
            'confirmation_token' => $this->char(64)->null(),
            'confirmation_expiration' => $this->integer()->unsigned()->null(),
            'confirmed_at' => $this->integer()->unsigned()->null(),
            'last_active_at' => $this->integer()->unsigned(),
            'created_at' => $this->integer()->unsigned(),
            'updated_at' => $this->integer()->unsigned(),
        ], $tableOptions);

        $this->createTable('{{account_access_token}}', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'account_id' => $this->char(16)->notNull(),
            'app' => $this->string(255)->notNull(),
            'token' => $this->char(64)->notNull(),
            'expired_at' => $this->integer()->unsigned()->notNull(),
            'last_active_at' => $this->integer()->unsigned()->null(),
            'created_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%account_vendor_auth}}', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'account_id' => $this->char(16)->notNull(),
            'vendor' => $this->string(32)->notNull(),
            'access_token' => $this->text()->notNull(),
            'data' => $this->text()->null(),
            'created_at' => $this->integer()->unsigned(),
        ], $tableOptions);

        $this->addPrimaryKey('account_id', '{{%account}}', 'id');

        $this->addForeignKey(
            'account_of_access_token',
            '{{%account_access_token}}', 'account_id',
            '{{%account}}', 'id',
            'CASCADE'
        );

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
        $this->dropForeignKey('account_of_access_token', '{{%account_access_token}}');

        $this->dropTable('{{%account}}');
        $this->dropTable('{{%account_access_token}}');
        $this->dropTable('{{%account_vendor_auth}}');
    }
}
