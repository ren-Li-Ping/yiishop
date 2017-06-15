<h3>文章表</h3>
<?=\yii\bootstrap\Html::a('添加文章',['article/add'],['class'=>'btn btn-info btn-xs'])?>
<table class="table table-hover">
    <tr>
        <th>文章名称</th>
        <th>文章简介</th>
        <th>文章分类</th>
        <th>排序</th>
        <th>状态</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->name?></td>
        <td><?=$model->intro?></td>
        <td><?=$model->cate->name?></td><!--用一对一hasone在模型中-->
        <td><?=$model->sort?></td>
        <td><?=$model->status?></td>
        <td><?=date('Y-m-d H:i:s',$model->create_time)?></td>
        <td>

            <?=\yii\bootstrap\Html::a('修改',['article/edit','id'=>$model->id],['class'=>'btn btn-info btn-xs'])?>
            <?=\yii\bootstrap\Html::a('删除',['article/del','id'=>$model->id],['class'=>'btn btn-info btn-xs'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>