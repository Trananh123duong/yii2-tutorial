<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string|null $description
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $deleted_at
 *
 * @property Categories[] $categories
 * @property CategoryPost[] $categoryPosts
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['content', 'description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['status'], 'in', 'range' => ['active', 'inactive']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'description' => 'Description',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Categories::class, ['id' => 'category_id'])->viaTable('category_post', ['post_id' => 'id']);
    }

    /**
     * Gets query for [[CategoryPosts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryPosts()
    {
        return $this->hasMany(CategoryPost::class, ['post_id' => 'id']);
    }
}
