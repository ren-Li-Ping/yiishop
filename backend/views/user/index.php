<table class="table table-hover">
    <tr>
        <th>用户名</th>
        <th>邮箱</th>
        <th>状态</th>
        <th>注册时间</th>
        <th>更新时间</th>
        <th>最后登录ip</th>
        <th>最后登录时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->username?></td>
            <td><?=$model->email?></td>
            <td><?=$model->status?></td>
            <td><?=date('Y-m-d H:i:s',$model->created_at)?></td>
            <td><?=date('Y-m-d H:i:s',$model->updated_at)?></td>
            <td><?=$model->ip_end?></td>
            <td><?=date('Y-m-d H:i:s',$model->end_time)?></td>
            <td>
                <?=\yii\bootstrap\Html::a('修改',['user/edit','id'=>$model->id],['class'=>'btn btn-info btn-sm'])?>

                <?=\yii\bootstrap\Html::a('删除',['user/del','id'=>$model->id],['class'=>'btn btn-info btn-sm'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>