<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\web\Request;
use yii\web\UploadedFile;

class BrandController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models = Brand::find()->where(['>=','status',0])->all();
        return $this->render('index',['models'=>$models]);
    }
    //添加品牌
    public function actionAdd(){
        //实力化
        $model = new Brand();
        //$request = \Yii::$app->request;
        //接收提交数据
        if($model->load(\Yii::$app->request->post())){
            //实力化上传对象
            $model->imgFile = UploadedFile::getInstance($model,'logo');
            //验证数据
            if($model->validate()){
                //var_dump($model->imgFile);exit;
                if($model->imgFile){
                    $fileName='/images/brand/'.uniqid().'.'.$model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    //保存图片地址到数据表
                    $model->logo=$fileName;

                }

                $model->save();
                \Yii::$app->session->setFlash('success','品牌添加成功');
                return $this->redirect(['brand/index']);
            }
        }
            return $this->render('add',['model'=>$model]);
    }
    //修改
    public function actionEdit($id){
        $model = Brand::findOne(['id'=>$id]);
        //$request = \Yii::$app->request;
        //接收提交数据
        if($model->load(\Yii::$app->request->post())){
            //实力化上传对象
            $model->imgFile = UploadedFile::getInstance($model,'logo');
            //验证数据
            if($model->validate()){
                //var_dump($model->imgFile);exit;
                if($model->imgFile){
                    $fileName='/images/brand/'.uniqid().'.'.$model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    //保存图片地址到数据表
                    $model->logo=$fileName;

                }

                $model->save();
                \Yii::$app->session->setFlash('success','品牌添加成功');
                return $this->redirect(['brand/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    //删除
    public function actionDel($id){
        $model = Brand::findOne(['id'=>$id]);
        $model->status=-1;
        \Yii::$app->session->setFlash('success','删除成功');
        $model->save();
        return $this->redirect(['brand/index']);
    }
}
