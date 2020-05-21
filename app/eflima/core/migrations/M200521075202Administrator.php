<?php

namespace eflima\core\migrations;

use yii\db\Migration;

/**
 * Class M200521075202Administrator
 */
class M200521075202Administrator extends Migration
{
    /**
     * @inheritDoc
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%administrator}}', [
            'id' => $this->primaryKey()->unsigned(),
            'account_id' => $this->integer()->unsigned()->notNull(),
            'uuid' => $this->char(36)->unique()->notNull(),
            'first_name' => $this->text()->notNull(),
            'last_name' => $this->text()->null(),
            'created_at' => $this->text()->notNull(),
            'updated_at' => $this->text()->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'account_of_administrator',
            '{{%administrator}}', 'account_id',
            '{{%account}}', 'id',
            'CASCADE'
        );
    }

    /**
     * @inheritDoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('account_of_administrator', '{{%administrator}}');

        $this->dropTable('administrator');
    }
}
