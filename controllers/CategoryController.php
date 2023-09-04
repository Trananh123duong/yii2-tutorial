<?php

namespace app\controllers;

use app\models\Category;
use Yii;
use yii\web\Response;

class CategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        // return $this->render('index');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $categories = Category::find()->where(['deleted_at' => null])->all();
        return $categories;
    }

    public function actionCreate()
    {
        // Định nghĩa hành động để hiển thị trang tạo danh mục
        // Chẳng hạn, bạn có thể sử dụng view và form để tạo danh mục mới
        return $this->render('create');
    }

    public function actionStore()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $postData = Yii::$app->request->post();

        // Tạo một mô hình danh mục mới và thiết lập giá trị của nó
        $model = new Category();
        $model->attributes = $postData;

        if ($model->save()) {
            return ['success' => true, 'message' => 'Category created successfully.'];
        } else {
            return ['success' => false, 'errors' => $model->getErrors()];
        }
    }

    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = Category::findOne($id);

        // Kiểm tra xem danh mục tồn tại
        if ($model === null) {
            return ['success' => false, 'message' => 'Không tìm thấy danh mục.'];
        }

        // Kiểm tra xem danh mục đã bị xóa mềm trước đó
        if ($model->isDeleted()) {
            return ['success' => false, 'message' => 'Danh mục đã bị xóa mềm trước đó.'];
        }

        // Đặt giá trị deleted_at thành thời gian hiện tại
        $model->deleted_at = time();

        // Lưu mà không kiểm tra validation
        if ($model->save(false)) {
            return ['success' => true, 'message' => 'Danh mục đã được xóa mềm thành công.'];
        } else {
            return ['success' => false, 'message' => 'Đã có lỗi xảy ra khi xóa danh mục.'];
        }
    }

    public function actionView($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = Category::findOne($id);

        if ($model === null) {
            return ['success' => false, 'message' => 'Không tìm thấy danh mục.'];
        }

        if ($model->isDeleted()) {
            return ['success' => false, 'message' => 'Danh mục đã bị xóa mềm.'];
        }

        return ['success' => true, 'category' => $model];
    }

    public function actionEdit($id)
    {
        return $this->redirect(['update', 'id' => $id]);
    }


    public function actionUpdate($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = Category::findOne($id);

        if ($model === null) {
            return ['success' => false, 'message' => 'Không tìm thấy danh mục.'];
        }

        if ($model->isDeleted()) {
            return ['success' => false, 'message' => 'Danh mục đã bị xóa mềm.'];
        }

        $postData = Yii::$app->request->post();
        if ($model->load($postData) && $model->save()) {
            return ['success' => true, 'message' => 'Danh mục đã được cập nhật thành công.', 'category' => $model];
        } else {
            return ['success' => false, 'message' => 'Đã có lỗi xảy ra khi cập nhật danh mục.', 'errors' => $model->errors];
        }
    }
}
