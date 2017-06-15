<?php

namespace backend\controllers;


use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\ArticleDetail;

class ArticleController extends \yii\web\Controller
{
    //文章列表
    public function actionIndex()
    {
        //找到文章分类的所有数据，并赋值
        $cate = ArticleCategory::find()->all();
        $models = Article::find()->all();
        return $this->render('index',['models'=>$models,'cate'=>$cate]);
    }


    //添加文章
    public function actionAdd(){
        //找到文章分类的所有数据，并赋值
        $kk = ArticleCategory::find()->all();
        $model = new Article();
        $model2 = new ArticleDetail();

        if(\yii::$app->request->isPost){
            $model2->load(\yii::$app->request->post());
            $model->load(\yii::$app->request->post());

            if($model->validate()||$model2->validate()){
                $model->create_time = time();
                $model->save();
                $model2->article_id=$model->id;
                $model2->save();
                //var_dump($model2->content);exit;
                return $this->redirect(['article/index']);
            }
        }
        return $this->render('add',['model'=>$model,'kk'=>$kk,'model2'=>$model2]);//$kk把文章分类数据传送到文章添加页面
    }

    //修改文章
    public function actionEdit($id){
        $model = Article::findOne(['id'=>$id]);
        $kk = ArticleCategory::find()->all();
        $model2 = ArticleDetail::findOne(['article_id'=>$id]);//查找文章详情
        if(\yii::$app->request->isPost){
            $model2->load(\yii::$app->request->post());
            $model->load(\yii::$app->request->post());

            if($model->validate()||$model2->validate()){
                $model->create_time = time();
                $model->save();
                $model2->save();
                //var_dump($model2->content);exit;
                return $this->redirect(['article/index']);
            }
        }
        return $this->render('add',['model'=>$model,'kk'=>$kk,'model2'=>$model2]);//$kk把文章分类数据传送到文章添加页面
    }


    //删除文章

    public function actionDel($id){
        $model = Article::findOne(['id'=>$id]);
        $model->status=-1;
        $model->save();
        return $this->redirect(['article/index']);
    }
    //查看文章

}
