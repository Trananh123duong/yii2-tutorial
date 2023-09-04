<?php

use yii\db\Migration;

/**
 * Class m230904_020825_seed_data
 */
class m230904_020825_seed_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Chèn dữ liệu vào bảng "categories"
        $this->insert('categories', [
            'title' => 'Category 1',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('categories', [
            'title' => 'Category 2',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        // Chèn dữ liệu vào bảng "posts"
        $this->insert('posts', [
            'title' => 'Post 1',
            'content' => 'Content of Post 1',
            'status' => 'active',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('posts', [
            'title' => 'Post 2',
            'content' => 'Content of Post 2',
            'status' => 'inactive',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        // Chèn dữ liệu vào bảng trung gian "category_post"
        $this->batchInsert('category_post', ['category_id', 'post_id'], [
            [1, 1], // Bài viết 1 thuộc danh mục 1
            [1, 2], // Bài viết 2 thuộc danh mục 1
            [2, 2], // Bài viết 2 thuộc danh mục 2
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Xóa dữ liệu từ bảng trung gian "category_post"
        $this->delete('category_post');

        // Xóa dữ liệu từ bảng "posts"
        $this->delete('posts');

        // Xóa dữ liệu từ bảng "categories"
        $this->delete('categories');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230904_020825_seed_data cannot be reverted.\n";

        return false;
    }
    */
}
