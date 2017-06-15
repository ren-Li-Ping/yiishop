<?php
namespace backend\controllers;

use backend\models\User;
use yii\web\Controller;

class UserController extends Controller{
    public function actionAdd(){
        $user = new User();
        if($user->load(\Yii::$app->request->post())&& $user->validate()){
            
        }
    }
}