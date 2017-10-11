<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\views\widgets\calendario;

/**
 * Description of CalendarioAsset
 *
 * @author Edson
 */
class CalendarioAsset extends \yii\web\AssetBundle {
    
    public $css = [
        'css/zabuto_calendar.min.css'
    ];
    
    public $js = [
        'js/zabuto_calendar.min.js'
    ];
    
    public $depends = [
       'yii\web\JqueryAsset',
    ];
    
    public function init(){
        $this->sourcePath = __DIR__."/assets";
        parent::init();
    }
    
    
    
}
