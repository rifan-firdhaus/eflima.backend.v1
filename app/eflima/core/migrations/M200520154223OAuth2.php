<?php

namespace eflima\core\migrations;

use yii\db\Migration;

/**
 * Class M200520154223OAuth2
 */
class M200520154223OAuth2 extends Migration
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

        $this->createTable('{{%oauth2_client}}', [
            'id' => $this->string(64)->notNull(),
            'client_secret' => $this->string(64)->notNull(),
            'is_public' => $this->boolean()->defaultValue(false)->notNull(),
            'last_activity_at' => $this->integer()->unsigned()->null(),
            'created_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%oauth2_access_token}}', [
            'id' => $this->primaryKey()->unsigned(),
            'client_id' => $this->string(64)->notNull(),
            'account_id' => $this->integer()->unsigned()->notNull(),
            'token' => $this->text()->notNull(),
            'expiration' => $this->integer()->unsigned()->notNull(),
            'is_granted' => $this->boolean()->defaultValue(true)->notNull(),
            'scope' => $this->string(255)->null(),
            'last_activity_at' => $this->integer()->unsigned()->null(),
            'created_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%oauth2_authorization_code}}', [
            'id' => $this->primaryKey()->unsigned(),
            'client_id' => $this->string(64)->notNull(),
            'account_id' => $this->integer()->unsigned()->notNull(),
            'code' => $this->text()->notNull(),
            'redirect_uri' => $this->text()->notNull(),
            'is_used' => $this->boolean()->defaultValue(false)->notNull(),
            'scope' => $this->string(255)->null(),
            'expiration' => $this->integer()->unsigned()->notNull(),
            'used_at' => $this->integer()->unsigned(),
            'created_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('client_id', '{{%oauth2_client}}', 'id');

        $this->addForeignKey(
            'client_of_access_token',
            '{{%oauth2_access_token}}', 'client_id',
            '{{%oauth2_client}}', 'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'account_of_access_token',
            '{{%oauth2_access_token}}', 'account_id',
            '{{%account}}', 'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'account_of_authorization_code',
            '{{%oauth2_authorization_code}}', 'account_id',
            '{{%account}}', 'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'client_of_authorization_code',
            '{{%oauth2_authorization_code}}', 'client_id',
            '{{%oauth2_client}}', 'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('client_of_access_token', '{{%oauth2_access_token}}');
        $this->dropForeignKey('account_of_access_token', '{{%oauth2_access_token}}');
        $this->dropForeignKey('account_of_authorization_code', '{{%oauth2_authorization_code}}');
        $this->dropForeignKey('client_of_authorization_code', '{{%oauth2_authorization_code}}');

        $this->dropTable('{{%oauth2_access_token}}');
        $this->dropTable('{{%oauth2_authorization_code}}');
        $this->dropTable('{{%oauth2_client}}');
    }
}
