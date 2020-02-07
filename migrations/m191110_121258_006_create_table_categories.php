<?php

use yii\db\Migration;

class m191110_121258_006_create_table_categories extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(10),
            'title' => $this->string()->notNull(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue('1'),
            'menu_id' => $this->integer(10),
            'parent_id' => $this->integer(10)->notNull()->defaultValue('1'),
            'url' => $this->string()->notNull()->defaultValue('#'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex('parent_id', '{{%categories}}', 'parent_id');
        $this->addForeignKey('categories_ibfk_1', '{{%categories}}', 'parent_id', '{{%menu}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%categories}}');
    }
}
