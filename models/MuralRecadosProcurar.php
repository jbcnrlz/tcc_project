<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class MuralRecadosProcurar extends MuralRecados
{
    public $search;
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['titulo', 'recado', 'departamento', 'dta_cadastro', 'dta_termino_visualizacao', 'dta_notificacao'], 'safe'],
            [['search'],'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = MuralRecados::find()->indexBy('id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                  'pageSize' => Yii::$app->params['pageSize'],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->orFilterWhere([
            'id' => $this->search,
            'status' => $this->search,
            'dta_cadastro' => $this->search,
            'dta_termino_visualizacao' => $this->search,
            'dta_notificacao' => $this->search,
        ]);

        $query->orFilterWhere(['like', 'titulo', $this->search])
            ->orFilterWhere(['like', 'recado', $this->search])
            ->orFilterWhere(['like', 'departamento', $this->search]);

        return $dataProvider;
    }
    
    public function searchMuralHome($curso = null)
    {
        $query = MuralRecados::find()->indexBy('id');
        $dataAtual = date("Y-m-d");
        
        if($curso === null){
            $query->where("'".$dataAtual."' <= dta_termino_visualizacao AND status=1");
        }else{
           $query->where("'".$dataAtual."' <= dta_termino_visualizacao AND status=1 AND curso_id = '".$curso."'");
        }    
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
               'defaultOrder'=>[
                   'dta_notificacao'=>SORT_ASC,
                 
               ],
            ],
            'pagination' => [
                  'pageSize' => 3,
            ],
        ]);

        return $dataProvider;
    }
    
    
}
