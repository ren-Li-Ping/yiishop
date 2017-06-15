<?=\yii\bootstrap\Html::a('添加商品',['goods-category/add'],['class'=>'btn btn-info btn-xs']) ?>
<table class="table table-hover">
    <tr>
        <th>分类名</th>
        <th>商品分类</th>
        <th>商品简介</th>
        <th>分类操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <th><?=$model->name?></th>
            <!--找到父级，首先判断如果当前商品就是一级分类（parent_id=0）就没有父分类，如果不是就输出下一级-->
            <th><?=$model->parent_id ? $model->parent->name:'没有父类'?></th>
            <th><?=$model->intro?></th>
            <th><?=\yii\bootstrap\Html::a('修改',['goods-category/edit','id'=>$model->id],['class'=>'btn btn-info btn-xs']) ?>
                <?=\yii\bootstrap\Html::a('删除',['goods-category/del','id'=>$model->id],['class'=>'btn btn-info btn-xs']) ?>
            </th>
        </tr>
    <?php endforeach;?>
</table>