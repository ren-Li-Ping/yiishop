<table class="table table-info" style="background: #666">
    <tr>
    <th style="text-align: center">商品名称</th>
</tr>
<tr>
    <td><?=$goods['name']?></td>
    <td><?=\yii\bootstrap\Html::img($goods->logo,['width'=>'60'])?></td>
</tr>
</table><table class="table table-info">
    <tr>
        <th style="text-align: center">商品介绍</th>
    </tr>
    <tr>
        <td><?=$intro['content']?></td>
    </tr>
</table>