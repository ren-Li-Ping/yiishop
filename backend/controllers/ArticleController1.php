<?php

namespace backend\Controllers;

use backend\models\Article;

class ArticleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionAdd(){
        $model=new Article();
        return $this->render('add',['model'=>$model]);
    }
}
