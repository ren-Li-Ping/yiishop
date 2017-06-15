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
    <?php foreach($users as $user):?>
        <tr>
            <td><?=$user->username?></td>
            <td><?=$user->email?></td>
            <td><?=$user->status?></td>
            <td><?=date('Y-m-d H:i:s',$user->created_at)?></td>
            <td><?=date('Y-m-d H:i:s',$user->updated_at)?></td>
            <td><?=$user->ip_end?></td>
            <td><?=date('Y-m-d H:i:s',$user->end_time)?></td>
            <td>
                <?=\yii\bootstrap\Html::a('修改',['user/edit','id'=>$user->id],['class'=>'btn btn-info btn-sm'])?>

                <?=\yii\bootstrap\Html::a('删除',['user/del','id'=>$user->id],['class'=>'btn btn-info btn-sm'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>