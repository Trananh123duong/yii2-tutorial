<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category_post}}`.
 */
class m230904_014216_create_category_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category_post}}', [
            'category_id' => $this->integer()->notNull(),
            'post_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pk-category_post', 'category_post', ['category_id', 'post_id']);
        
        $this->addForeignKey('fk-category_post-category', 'category_post', 'category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-category_post-post', 'category_post', 'post_id', 'posts', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category_post}}');
    }
}
