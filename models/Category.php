<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $deleted_at
 *
 * @property CategoryPost[] $categoryPosts
 * @property Posts[] $posts
 */
class Category extends \yii\db\ActiveRecord
{
    const NOT_DELETED = null; // Giá trị mặc định cho deleted_at khi bản ghi chưa bị xóa

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
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

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            // Đặt giá trị deleted_at thành thời gian hiện tại
            $this->deleted_at = new Expression('NOW()');
            $this->save(false); // Lưu mà không kiểm tra validation

            return false; // Ngăn chặn việc xóa thực sự
        } else {
            return false;
        }
    }

    public function isDeleted()
    {
        return $this->deleted_at !== self::NOT_DELETED;
    }

    public function restore()
    {
        // Đặt giá trị deleted_at thành giá trị mặc định (NULL) để khôi phục bản ghi
        $this->deleted_at = self::NOT_DELETED;
        return $this->save(false);
    }

    /**
     * Gets query for [[CategoryPosts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryPosts()
    {
        return $this->hasMany(CategoryPost::class, ['category_id' => 'id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Posts::class, ['id' => 'post_id'])->viaTable('category_post', ['category_id' => 'id']);
    }
}
