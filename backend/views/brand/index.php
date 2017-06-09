<h3>品牌信息表</h3>
<?=\yii\bootstrap\Html::a('添加',['brand/add'],['class'=>'btn btn-info btn-sm'])?>
<table class="table table-hover">
    <tr>
        <th>名称</th>
        <th>介绍</th>
        <th>LOGO</th>
        <th>排序</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->name?></td>
        <td><?=$model->intro?></td>
        <td><?=\yii\bootstrap\Html::img($model->logo,['width'=>'60'])?></td>
        <td><?=$model->sort?></td>
        <td><?=$model->status?></td>
        <td><?=\yii\bootstrap\Html::a('修改',['brand/edit','id'=>$model->id],['class'=>'btn btn-warning btn-sm'])?>
        <?=\yii\bootstrap\Html::a('删除',['brand/del','id'=>$model->id],['class'=>'btn btn-warning btn-sm'])?></td>
    </tr>
    <?php endforeach;?>
</table>
