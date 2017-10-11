<?php
use kartik\datecontrol\Module;

$params = require(__DIR__ . '/params.php');

$config = [
    'id'=>'scrootcc',
    'name'=>'Software TCC',
    'sourceLanguage' => 'pt-BR',
    'language' => 'pt-BR',
    'timeZone'=>'America/Sao_Paulo',
    'charset'=>'UTF-8',
//    //Comando de Manutenção
//    'catchAll'=>[
//        'controle/action'
//    ],
//    'aliases'=>[
//
//    ],
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log','app\components\Configuracao'],
    'components' => [
      
        'request' => [
            'cookieValidationKey' => 'SSoKO5elXnQE5PYYnhfp_lXb_vp31uQf',
            'baseUrl' => '',
        ],
        
        'formatter' => [            
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:d/m/Y',
            'datetimeFormat' => 'php:d/m/Y H:i:s',
            'timeFormat' => 'php:H:i:s',
            'decimalSeparator' => ',',
            'thousandSeparator' => '.',
            'currencyCode' => 'R$',
        ],
        
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Usuario',
            'enableAutoLogin' => true,
           'loginUrl' => ['/']
        ],
       
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{autorizacao_item}}',
            'assignmentTable' => '{{autorizacao_atribuicoes}}',
            'itemChildTable' => '{{autorizacao_item_hierarquia}}',
            'ruleTable' => '{{autorizacao_regras}}',
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'mailer' => [
            'viewPath' => '@app/mail',
            'useFileTransport' => false,
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mailtrap.io',
                'username' => 'site@fatecgarca.edu.br',
                'password' => 'fe99a963305fff',
                'port' => '2525',
                'encryption' => 'tls',
            ],
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
        'db' => require(__DIR__ . '/db.php'),

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                
                '<alias:recuperar-senha|corpo-docente|contato|material|redefinir-senha|index>' => 'site/<alias>',
                '/avatar'=>'site/avatar',
                '/avatar/<img:\w+>'=>'site/avatar',
               
                '/projeto/meu-projeto/cadastrar'=>'projeto/cadastrar',
                '/projeto/meu-projeto/<id:\w+>/visualizar'=>'projeto/visualizar',
                '/apresentacao/index/<param:\w+>' => 'apresentacao/index',
             
//                '/redefinir-senha'=>'site/reset-password',
//                '<alias:product>/<id:\w+>' => 'site/<alias>',
//                '<controller:\w+>/<id:\w+>' => '<controller>',
//                '<controller:\w+>/<action:\w+>/<id:\w+>' => '<controller>/<action>',
//                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',


            ],
        ],

    ],
    'modules'=>[
        'dynagrid'=>[
            'class'=>'\kartik\dynagrid\Module',
            // other settings (refer documentation)
        ],
        'gridview'=>[
            'class'=>'\kartik\grid\Module',
            // other module settings
        ],
        'datecontrol' => [
            'class' => 'kartik\datecontrol\Module',
            // format settings for displaying each date attribute
            'displaySettings' => [
                Module::FORMAT_DATE => 'dd/MM/yyyy',
                Module::FORMAT_TIME => 'hh:mm:ss a',
                Module::FORMAT_DATETIME => 'dd/MM/yyyy hh:mm',
            ],
            // format settings for saving each date attribute
            'saveSettings' => [
                Module::FORMAT_DATE => 'php:Y-m-d', // saves as unix timestamp
                Module::FORMAT_TIME => 'php:H:i:s',
                Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
            ],
        
            // set your display timezone
            'displayTimezone' => 'America/Sao_Paulo',
            // set your timezone for date saved to db
            'saveTimezone' => 'UTC',
            // automatically use kartik\widgets for each of the above formats
            'autoWidget' => true,
        ],  
    ],

    'as access' => [
			 'class' => 'app\components\AccessControl',
			 'allowActions' => [
			    '/datecontrol/*',
                            '/dynagrid/*',
                            '/gridview/*',
                            '/gridview/export/download',
                            'site/*',                  
                            'usuario/*',
                            'upload/avatarPerfil/*',
                            'permissao/*', // only in dev mode
			],
	],

	'params' => $params,
];

if (YII_ENV_DEV) {
//
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
//    ];
//
//    $config['components']['assetManager']['forceCopy'] = true;

//    $config['bootstrap'][] = 'gii';
//    $config['modules']['gii'] = [
//        'class' => 'yii\gii\Module',
//    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii']['class'] = 'yii\gii\Module';
    $config['modules']['gii']['generators'] = [
         'sintret' => [
            'class' => 'app\components\gii\generators\crud\Generator',
            'templates' => [ //setting for out templates
                    'Crud Completo' => '@app/components/gii/generators/crud/completo',
                    'Crud Sem view' => '@app/components/gii/generators/crud/semtview',
            ]
        ],
        'sintretModel' => [
            'class' => 'app\components\gii\generators\model\Generator'
        ]

    ];
}

return $config;
