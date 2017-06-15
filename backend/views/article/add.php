<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'article_category_id')->dropDownList(\yii\helpers\ArrayHelper::map($kk,'id','name'));
echo $form->field($model2,'content')->textarea();
echo $form->field($model,'sort');
echo $form->field($model,'status')->radioList([1=>'正常',0=>'隐藏',-1=>'删除']);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);


\yii\bootstrap\ActiveForm::end();