<?php
/**
 * Autor: Edson
 * Data: 16/01/2017
 * Horas: 19:12
 */

namespace app\assets;

use yii\web\AssetBundle;

class AdminAssets extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/appb.min.css',
        'css/red.css',
//        'https://fonts.googleapis.com/css?family=Montserrat:400,700',
        'css/bootstrap-switch.min.css'
    ];

    public $js = [
        'js/icheck.min.js',
        'js/appb.min.js',
        'js/bootbox.min.js',
        'js/jquery.mousewheel.min.js',
        'js/jquery.slimscroll.min.js',
        'js/jquery.mask.min.js',
        'js/bootstrap-switch.min.js',

    ];

    public $depends = [
        'dmstr\web\AdminLteAsset',
        'yii\web\JqueryAsset',
    ];

}