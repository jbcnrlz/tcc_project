<?php
////documentação http://zabuto.com/dev/calendar/examples/set_legend.html
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\views\widgets\calendario;

/**
 * Description of Calendario
 *
 * @author Edson
 */
class Calendario extends \yii\base\Widget{
   
    public function init(){
        parent::init();
        CalendarioAsset::register($this->getView());
        $this->getView()->registerJs('$("#calendario-academico").zabuto_calendar({
            legend: [
                {type: "block", label: "Evento Importante", classname: "grade-1"},
                
              ],
            ajax: {
                url: "site/calendario-eventos",
                modal: true
            },
      today: true, language: "pt"})');
    }
    
    public function run() {
        
        return "<div id='calendario-academico'></div>";
    }
    
}
