<?php

use yii\db\Migration;

class m191110_121258_002_create_table_menu extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(10),
            'name' => $this->string()->notNull(),
            'code' => $this->string()->notNull(),
            'status' => $this->tinyInteger(1)->defaultValue('1'),
            'descriprion' => $this->text(),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%menu}}');
    }
}
