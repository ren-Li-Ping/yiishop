<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\web\Request;
use yii\web\UploadedFile;
use xj\uploadify\UploadAction;
use crazyfd\qiniu\Qiniu;

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
            //var_dump(\Yii::$app->request->post());exit;
            //实力化上传对象
            //$model->imgFile = UploadedFile::getInstance($model,'logo');
            //验证数据
            if($model->validate()){
                //var_dump($model->imgFile);exit;
//                if($model->imgFile){
//                    $fileName='/images/brand/'.uniqid().'.'.$model->imgFile->extension;
//                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
//                    //保存图片地址到数据表
//                    $model->logo=$fileName;
//
//                }

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
            //$model->imgFile = UploadedFile::getInstance($model,'logo');
            //验证数据
            if($model->validate()){
                //var_dump($model->imgFile);exit;
//                if($model->imgFile){
//                    $fileName='/images/brand/'.uniqid().'.'.$model->imgFile->extension;
//                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
//                    //保存图片地址到数据表
//                    $model->logo=$fileName;
//
//                }

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




    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                //保存到服务器
                'afterSave' => function (UploadAction $action) {

                    $imgUrl = $action->getWebUrl();
//调用七牛云，将图片上传到七牛云
                    $qiniu = \yii::$app->qiniu;
                    $qiniu->uploadFile(\Yii::getAlias('@webroot').$imgUrl,$imgUrl);
//获取该图片在七牛云的地址
                    $url = $qiniu->getLink($imgUrl);
                    $action->output['fileUrl'] = $url;

//                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
//                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
//                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                },
            ],
        ];
    }



   /* //七牛云测试上传
    public function actionTest(){
        $ak = 'z8Gigpm3a0saKkcOnitN-7CRt0GnITWcMT-2BdxK';
        $sk = 'OOBdSLq2xQCvc65An6qRzLU_Mqy1ymxMchXAY9Xq';
        $domain = 'http://or9rmjalm.bkt.clouddn.com/';
        $bucket = 'yunduan';

        $qiniu = new Qiniu($ak, $sk,$domain, $bucket);
        //准备上传的文件,使用绝对路径
        $fileName = \Yii::getAlias('@webroot').'/upload/test.jpg';
        $key ='test.jpg';//文件
        $rs = $qiniu->uploadFile($fileName,$key);
        $url = $qiniu->getLink($key);
        var_dump($url);
    }*/
}
