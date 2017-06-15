<?php
namespace backend\controllers;

use backend\models\LoginForm;
use backend\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UserController extends Controller{
    //添加管理员
    public function actionAdd()
    {
        $model = new User(['scenario'=>User::SCENARIO_ADD]);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            \Yii::$app->session->setFlash('success','添加成功');
            return $this->redirect(['user/index']);
        }
        return $this->render('add',['model'=>$model]);
    }

    //修改
    public function actionEdit($id){
        $model = User::findOne(['id'=>$id]);
        if($model==null){
            throw new NotFoundHttpException('账号不存在');
        }
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->end_time = time();
            $model->save();
            \Yii::$app->session->setFlash('success','修改成功');
            return $this->redirect(['user/index']);
        }
        return $this->render('add',['model'=>$model]);
    }

    public function actionDel($id){
        User::findOne(['id'=>$id])->delete();
        return $this->redirect(['user/index']);
    }

    //登录
    public function actionLogin(){
        $model = new LoginForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->login()){
                //$model->end_time = time();
                //$model->save();
                \Yii::$app->session->setFlash('success','登录成功');
                return $this->redirect(['user/index']);
            }
        }
        return $this->render('login',['model'=>$model]);

    }

    //退出登录
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->redirect(['admin/login']);
    }

    public function actionIndex(){
        $models = User::find()->all();
        return $this->render('index',['models'=>$models]);
    }
}