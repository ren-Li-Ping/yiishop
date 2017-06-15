<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
//echo $form->field($model,'sn')->hiddenInput();
echo $form->field($model,'logo')->hiddenInput();
echo \yii\bootstrap\Html::fileInput('test',null,['id'=>'test']);//图添加片
echo \xj\uploadify\Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 40,
        'onUploadError' => new \yii\web\JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadSuccess' => new \yii\web\JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data.fileUrl);
        //将上传成功后的图片地址写入img标签中
        $("#img_logo").attr("src",data.fileUrl).show();
        //将上传成功后的图片地址写入logo字段中
        $("#goods-logo").val(data.fileUrl);

    }
}
EOF
        ),
    ]
]);
if($model->logo){
    echo \yii\helpers\Html::img($model->logo);

}
echo \yii\helpers\Html::img('',['style'=>'display:none','id'=>'img_logo','height'=>'80']);
echo $form->field($model,'goods_category_id')->hiddenInput();
echo '<ul id="treeDemo" class="ztree"></ul>';
echo $form->field($model,'brand_id')->dropDownList(\yii\helpers\ArrayHelper::map($brands,'id','name'));
echo $form->field($model,'market_price');
echo $form->field($model,'shop_price');
echo $form->field($model2,'content')->widget('kucha\ueditor\UEditor',[]);
//echo $form->field($model2,'content');
echo $form->field($model,'stock');
echo $form->field($model,'is_on_sale')->radioList([1=>'在售',0=>'下架']);
echo $form->field($model,'status')->radioList([1=>'正常',0=>'回收站']);
echo $form->field($model,'sort');
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();

//使用ztree，加载2个静态资源
/*<link rel="stylesheet" href="/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">
    <script type="text/javascript" src="/zTree/js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="/zTree/js/jquery.ztree.core.js"></script>*/
$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
$zNodes = \yii\helpers\Json::encode($categorys);
//var_dump($categorys);exit;
$js = new \yii\web\JsExpression(
    <<<JS
var zTreeObj;
    // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
    var setting = {
        data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "parent_id",
                rootPId: 0
            }
        },
        callback: {
		    onClick: function(event, treeId, treeNode) {
                //console.log(treeNode.id);
                //将选中节点的id赋值给表单goods_category_id
                $("#goods-goods_category_id").val(treeNode.id);
            }
	    }
    };
    // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
    var zNodes = {$zNodes};

    zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
    zTreeObj.expandAll(true);//展开所有节点
    //获取当前节点的父节点（根据id查找）
    var node = zTreeObj.getNodeByParam("id", $("#goods-goods_category_id").val(), null);
    zTreeObj.selectNode(node);//选中当前节点的父节点
JS

);
$this->registerJs($js);
$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');