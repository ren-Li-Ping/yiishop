<h3>文章详情表</h3>
<?=\yii\bootstrap\Html::a('添加文章',['article-detail/del'],['class'=>'btn btn-info btn-xs'])?>
<table class="table table-hover">
    <tr>
        <th>文章名称</th>
        <th>文章内容</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->cate->name?></td>
        <td><?=$model->content?></td>
        <td><?=\yii\bootstrap\Html::a('修改',['article-detail/edit','id'=>$model->id],['class'=>'btn btn-info btn-xs'])?>
            <?=\yii\bootstrap\Html::a('删除',['article-detail/del','id'=>$model->id],['class'=>'btn btn-info btn-xs'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>