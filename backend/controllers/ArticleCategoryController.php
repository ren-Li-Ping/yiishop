<?php

namespace backend\controllers;

use backend\models\ArticleCategory;

class ArticleCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models = ArticleCategory::find()->where(['>=','status',0])->all();
        return $this->render('index',['models'=>$models]);
    }
    //新增文章分类
    public function actionAdd(){
        $model = new ArticleCategory();
        //接收提交数据
        if($model->load(\Yii::$app->request->post())){
            //验证数据
            if($model->validate()){
                //保存数据
                $model->save();
                return $this->redirect(['article-category/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    //修改
    public function actionEdit($id){
        $model = ArticleCategory::findOne(['id'=>$id]);
        //接收提交数据
        if($model->load(\Yii::$app->request->post())){
            //验证数据
            if($model->validate()){
                //保存数据
                $model->save();
                return $this->redirect(['article-category/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }


    //删除
    public function actionDel($id){
        $model = ArticleCategory::findOne(['id'=>$id]);
        $model->status=-1;//伪删除，只是把状态的值该为了-1，斌没有真正的从数据表中删除
        \yii::$app->session->setFlash('success','删除成功');
        $model->save();
        return $this->redirect(['article-category/index']);
    }
}
