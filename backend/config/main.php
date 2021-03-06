<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language'=> 'zh-CN',
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            //'identityClass' => 'common\models\User',
            'identityClass' => 'backend\models\User',
            'enableAutoLogin' => true,//给予cookie
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        //伪静态
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        //七牛云
        'qiniu'=>[
            'class'=>\backend\components\Qiniu::className(),
            'up_host'=>'http://up-z2.qiniu.com',
            'accessKey'=>'z8Gigpm3a0saKkcOnitN-7CRt0GnITWcMT-2BdxK',
            'secretKey'=>'OOBdSLq2xQCvc65An6qRzLU_Mqy1ymxMchXAY9Xq',
            'bucket'=>'yunduan',
            'domain'=>'http://or9rmjalm.bkt.clouddn.com/'
        ]

    ],
    'params' => $params,
];
