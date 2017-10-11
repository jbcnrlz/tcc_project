<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class ProjetoProcura extends Projeto
{
    public $search;
    public $etapa_projeto;
    public $periodo;
    public $curso_id;
    public function rules()
    {
        return [
            [['id', 'status', 'orientador_id', 'orientador_sugestao_id', 'curso_id'], 'integer'],
            [['tema', 'periodo','etapa_projeto', 'palavra_chave', 'resumo', 'dta_cadastro', 'dta_atualizacao', 'matricula_ra'], 'safe'],
            [['search'],'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Projeto::find()->indexBy('id')->joinWith(['matriculaRa','orientador']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                  'pageSize' => Yii::$app->params['pageSize'],
            ],
        ]);
        
        $query->andFilterWhere(['<>', 'matricula.etapa_projeto', 4]);
        $query->andFilterWhere(['=', 'projeto.status', 1]);
         
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        } 

        $query->orFilterWhere(['like', 'tema', $this->search])
            ->orFilterWhere(['like', 'palavra_chave', $this->search])
            ->orFilterWhere(['like', 'resumo', $this->search])
            ->orFilterWhere(['like', 'matricula_ra', $this->search])
            ->orFilterWhere(['like', 'nome', $this->search])
            ->andWhere(['not', ['orientador_id'=>null]]);

        return $dataProvider;
    }
    
    public function searchProjetosAprovados($params)
    {
        
        $query = Projeto::find()->indexBy('id')->joinWith(['matriculaRa','relatorioParcials']);
         
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                  'pageSize' => 40,
            ],
        ]);
        
        if (!($this->load($params) && $this->validate())) {
//            return $dataProvider;
        } 
       
       $querySub = Apresentacao::find()->select('projeto_id')->joinWith('projeto')->where(['and',['etapa_projeto'=>$this->etapa_projeto]]);
     
          
      
       $query->orFilterWhere(['=','matricula.curso_id',$this->curso_id]);
       $query->andWhere(['=','matricula.periodo',$this->periodo]);
       $query->andFilterWhere(['=','projeto.status',1]);
       $query->andFilterWhere(['=','matricula.etapa_projeto',$this->etapa_projeto]);
       $query->andWhere(['not in','projeto.id',$querySub]);
    
       
        if(Yii::$app->params['qtde-relatorio'] == 2){
           $query->andFilterWhere(['=','relatorio_parcial.etapa_projeto',$this->etapa_projeto]);
           $query->andFilterWhere(['=','relatorio_parcial.fase',2]);
           $query->andFilterWhere(['=','relatorio_parcial.apto',1]);
       }else{
           $query->andFilterWhere(['=','relatorio_parcial.etapa_projeto',$this->etapa_projeto]);
           $query->andFilterWhere(['=','relatorio_parcial.fase',1]);
           $query->andFilterWhere(['=','relatorio_parcial.apto',1]);
       }
                 
                   
     


        return $dataProvider;
    }
}
