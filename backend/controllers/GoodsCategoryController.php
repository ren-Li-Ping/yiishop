<?php

namespace backend\controllers;

use backend\models\Goodscategory;
use yii\helpers\ArrayHelper;

class GoodsCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $mdoels = Goodscategory::find()->all();
        return $this->render('index',['models'=>$mdoels]);
    }

    //添加商品
    public function actionAdd(){
        $model = new Goodscategory();
        // 接收数据并验证
        if($model->load(\yii::$app->request->post()) && $model->validate()){
            //首先判断parent_id是否为0，为0就添加一级分类
            if($model->parent_id){
                //父分类
                $parent = Goodscategory::findOne(['id'=>$model->parent_id]);
                //添加到父分类下面，首先找到父分类
                $model->prependTo($parent);
            }else{
                //parent_id=0,添加一级分类
                $model->makeroot();
                \yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['goods-category/index']);
            }
        }
        //把树结构形式传到add页面
        //ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]]表示可以在add页面添加顶级分类
        //GoodsCategory::find()->asArray()->all()找到所有分类
        $categorys = ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],GoodsCategory::find()->asArray()->all());
       // var_dump($categorys);exit;
        return $this->render('add',['model'=>$model,'categorys'=>$categorys]);
    }

    public function actionEdit($id)
    {

        $model = GoodsCategory::findOne(['id' => $id]);
        $parent_id = $model->parent_id;
        if ($model == null) {//判断这个id是否存在
            throw new NotFoundHttpException('分类不存在');
        }
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            //判断是否是添加一级分类（parent_id是否为0）
            if ($model->parent_id) {
                //添加非一级分类
                $parent = GoodsCategory::findOne(['id' => $model->parent_id]);//获取上一级分类
                $model->prependTo($parent);//添加到上一级分类下面
            }else{
                //判断父id是否为0且没有发生改变
                if($model->parent_id == $parent_id && $model->parent_id==0){//为true时修改分类
                    $model->save();
                }else {

                    //添加一级分类
                    $model->makeRoot();
                }
            }

            \Yii::$app->session->setFlash('success', '添加成功');
            return $this->redirect(['goods-category/index']);
        }
        //合并数组ArrayHelper::merge
        $categorys = ArrayHelper::merge([['id' => 0, 'name' => '顶级分类', 'parent_id' => 0]], GoodsCategory::find()->asArray()->all());


        return $this->render('add', ['model' => $model, 'categorys' => $categorys]);

    }

    //删除
    public function actionDel($id){
        Goodscategory::findOne(['id'=>$id])->delete();
        return $this->redirect(['goods-category/index']);
    }
    public function actionTest(){
        //创建一级菜单
//        $yiji = new Goodscategory();//创建对象
//        $yiji->name = '男装品牌';
//        $yiji->parent_id = 0;
//        $yiji->makeroot();//  makeroot （） 将当前分类设为一级分类
//        var_dump($yiji);
    }

    //树插件
    public function actionZtree()
    {
        $categorys = GoodsCategory::find()->asArray()->all();

        return $this->renderPartial('ztree',['categorys'=>$categorys]);//不加载布局文件
    }
}
