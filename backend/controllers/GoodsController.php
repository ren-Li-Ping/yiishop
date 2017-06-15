<?php

namespace backend\controllers;

use backend\models\Brand;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsIntro;
use backend\models\GoodsSearchForm;
use xj\uploadify\UploadAction;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

class GoodsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //封装搜索表单方法
        $model = new GoodsSearchForm();
        $query = Goods::find();
        //接收商品表里面的数据进行搜索
        $model->search($query);

        $count=$query->count();
        $page=new Pagination([
            'totalCount'=>$count,
            'defaultPageSize'=>2,
        ]);
        $models=$query->offset($page->offset)->limit($page->limit)->all();
        //var_dump($models);exit;
        return $this->render('index',['models'=>$models,'page'=>$page,'model'=>$model]);
    }
    //添加商品
    public function actionAdd(){
        $model = new Goods();
        $brands = Brand::find()->all();
        $model2 = new GoodsIntro();

        //接收数据
        if($model->load(\Yii::$app->request->post()) && $model2->load(\Yii::$app->request->post())){
            //验证数据
            //var_dump($model->name);exit;
            if($model->validate()&&$model2->validate()){
                //var_dump($model->goods_category_id);exit;
                //$model->create_time = time();
                //生成sn，判断当天有没有商品添加，没有就生成一条
                if($goodsday=GoodsDayCount::findOne(['day'=>date('Y-m-d')])){
                    $count = ($goodsday->count)+1;
                    //var_dump($count);exit;
                    //
                    $sn=date('Ymd').str_pad($count,4,"0",STR_PAD_LEFT);
//                    var_dump($sn);exit;
                    $goodsday->count = $count;
                }else{
                    $sn = date('Ymd').str_pad(1,4,"0",STR_PAD_LEFT);
                    $goodsday = new GoodsDayCount();
                    $goodsday->day=date('Y-m-d');
                    $goodsday->count =1;
                }
                $model->sn =$sn;
                $model->create_time =time();
//                var_dump($model);exit;
                $goodsday->save();
                $model->save();
                $model2->goods_id = $model->id;
                $model2->save();


                \Yii::$app->session->setFlash('success','商品添加成功');
                return $this->redirect(['goods/index']);
            }
        }
        //把树结构形式传到add页面
        //ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]]表示可以在add页面添加顶级分类
        //GoodsCategory::find()->asArray()->all()找到所有分类
       // $categorys = ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],GoodsCategory::find()->asArray()->all());
        // var_dump($categorys);exit;
        $categorys=GoodsCategory::find()->all();
        return $this->render('add',['model'=>$model,'brands'=>$brands,'categorys'=>$categorys,'model2'=>$model2]);
    }


    // 修改
    public function actionEdit($id){
        $model = Goods::findOne(['id'=>$id]);
        //分类回显
        //$category = GoodsCategory::find(['goods_category_id'=>$id]);
        //品牌回显
        $brands = Brand::find()->all();
        $model2 = new GoodsIntro();

        //接收数据
        if($model->load(\Yii::$app->request->post()) && $model2->load(\Yii::$app->request->post())){
            //验证数据
            //var_dump($model->name);exit;
            if($model->validate()&&$model2->validate()){
                //var_dump($model->goods_category_id);exit;
                //$model->create_time = time();
                //生成sn，判断当天有没有商品添加，没有就生成一条
                if($goodsday=GoodsDayCount::findOne(['day'=>date('Y-m-d')])){
                    $count = ($goodsday->count)+1;
                    //var_dump($count);exit;
                    //
                    $sn=date('Ymd').str_pad($count,4,"0",STR_PAD_LEFT);
//                    var_dump($sn);exit;
                    $goodsday->count = $count;
                }else{
                    $sn = date('Ymd').str_pad(1,4,"0",STR_PAD_LEFT);
                    $goodsday = new GoodsDayCount();
                    $goodsday->day=date('Y-m-d');
                    $goodsday->count =1;
                }
                $model->sn =$sn;
                $model->create_time =time();
                //var_dump($model->sn);exit;
                $goodsday->save();
                $model->save();
                $model2->goods_id = $model->id;
                $model2->save();


                \Yii::$app->session->setFlash('success','商品添加成功');
                return $this->redirect(['goods/index']);
            }
        }
        //把树结构形式传到add页面
        //ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]]表示可以在add页面添加顶级分类
        //GoodsCategory::find()->asArray()->all()找到所有分类
        $categorys = ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],GoodsCategory::find()->asArray()->all());
        // var_dump($categorys);exit;
        //$categorys=GoodsCategory::find()->all();
        return $this->render('add',['model'=>$model,'brands'=>$brands,'categorys'=>$categorys,'model2'=>$model2]);
    }

    //删除

    public function actionDel($id){
         //$model = Goods::findOne(['id'=>$id])->delete();
         $model = Goods::findOne(['id'=>$id]);
        $model->status = 0;
        \Yii::$app->session->setFlash('success','删除成功');
        $model->save();
        return $this->redirect( ['goods/index']);
    }


    /*//树插件
    public function actionZtree(){
        $categorys = GoodsCategory::find()->asArray()->all();
        //var_dump($categorys);exit;
        return $this->renderPartial('ztree',['categorys'=>$categorys]);
    }*/

    //七牛云上传图片
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
    //查看详情
    public function actionView($id){
        $goods = Goods::findOne(['id'=>$id]);
        $intro = GoodsIntro::findOne(['goods_id'=>$id]);
//        var_dump($goods);
//        var_dump($intro);exit;
        return $this->render('view',['goods'=>$goods,'intro'=>$intro]);
    }
}
