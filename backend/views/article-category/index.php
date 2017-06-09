<h3>文章分类表</h3>
<?=\yii\bootstrap\Html::a('添加文章分类',['article-category/add'],['class'=>'btn btn-info btn-xs'])?>
<table class="table table-hover">
    <tr>
        <th>文章类型名称</th>
        <th>文章类型简介</th>
        <th>排序</th>
        <th>状态</th>
        <th>文章类型</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->name?></td>
        <td><?=$model->intro?></td>
        <td><?=$model->sort?></td>
        <td><?=$model->status?></td>
        <td><?=$model->is_help?></td>
        <td><?=\yii\bootstrap\Html::a('修改',['article-category/edit','id'=>$model->id],['class'=>'btn btn-info btn-xs'])?>
            <?=\yii\bootstrap\Html::a('删除',['article-category/del','id'=>$model->id],['class'=>'btn btn-warning btn-xs'])?></td>
    </tr>
    <?php endforeach;?>
</table>
