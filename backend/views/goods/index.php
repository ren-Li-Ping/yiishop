<h3 style="text-align: center">商品表</h3>
<?=\yii\bootstrap\Html::a('添加商品',['goods/add'],['class'=>'btn btn-info btn-xm'])?>
<?php
$form = \yii\bootstrap\ActiveForm::begin([
    'method'=>'get',
    //接收get方式传值，必须制定action路径
    'action'=>\yii\helpers\Url::to(['goods/index']),
    'options'=>['class'=>'form-inline']//搜索框的样式
]);

echo $form->field($model,'name')->textInput(['placeholder'=>'商品名称'])->label(false);
echo $form->field($model,'sn')->textInput(['placeholder'=>'商品货号'])->label(false);
echo $form->field($model,'minPrice')->textInput(['placeholder'=>'￥'])->label(false);
echo $form->field($model,'maxPrice')->textInput(['placeholder'=>'￥'])->label('-');
echo \yii\bootstrap\Html::submitButton('搜索',['class'=>'btn btn-info btn-xm','style'=>'position:absolute']);

\yii\bootstrap\ActiveForm::end();
?>




<table class="table table-hover">
    <tr>
        <td>商品名称</td>
        <td>商品货号</td>
        <td>商品图片</td>
        <td>商品分类</td>
        <td>商品品牌</td>
        <td>市场价格</td>
        <td>商品价格</td>
        <td>库存</td>
        <td>是否在售</td>
        <td>商品状态</td>
        <td>排序</td>
        <td>添加时间</td>
        <td>操作</td>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->name?></td>
        <td><?=$model->sn?></td>
        <td><?=\yii\bootstrap\Html::img($model->logo,['width'=>'60'])?></td>
        <td><?=$model->goods_category->name?></td>
        <td><?=$model->brand->name?></td>
        <td><?=$model->market_price?></td>
        <td><?=$model->shop_price?></td>
        <td><?=$model->stock?></td>
        <td><?=$model->is_on_sale?></td>
        <td><?=$model->status?></td>
        <td><?=$model->sort?></td>
        <td><?=date('Y-m-d',$model->create_time)?></td>
        <td>
            <?=\yii\bootstrap\Html::a('查看',['goods/view','id'=>$model->id],['class'=>'bnt btn-primary btn-sm'])?>

            <?=\yii\bootstrap\Html::a('修改',['goods/edit','id'=>$model->id],['class'=>'btn btn-warning btn-sm'])?>
            <?=\yii\bootstrap\Html::a('删除',['goods/del','id'=>$model->id],['class'=>'btn btn-danger btn-sm'])?>
            <?=\yii\bootstrap\Html::a('图片',['goods/pohto','id'=>$model->id],['class'=>'btn btn-success btn-sm'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php
//分页工具条

echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',

]);