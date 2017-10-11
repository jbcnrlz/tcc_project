<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class ProtocolosProcurar extends Protocolos
{
    public $search;
    public $data_inicial;
    public $data_final;
    
    public function rules()
    {
        return [
            [['id', 'numero', 'ano', 'projeto_id', 'classificacao'], 'integer'],
            [['descricao', 'dta_protocolo', 'dta_cadastro', 'dta_atualizacao'], 'safe'],
            [['search', 'data_inicial', 'data_final'],'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Protocolos::find()->indexBy('id')->innerJoinWith(['projeto']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder'=>['dta_protocolo'=>SORT_DESC],
            ],
            'pagination' => [
                  'pageSize' => Yii::$app->params['pageSize'],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

//        $query->orFilterWhere(['like', 'descricao', $this->search]);
//        $query->orFilterWhere(['like', 'projeto.tema', $this->search]);
//       
//        $query->andFilterWhere(['>=', 'dta_protocolo', $this->data_inicial])
//                            ->andFilterWhere(['<=', 'dta_protocolo', $this->data_final]);
        
        
        $query->orFilterWhere([
            'numero' => $this->classificacao,
            'ano' => $this->search,
            'projeto_id' => $this->search,
            'dta_protocolo' => $this->search,
            'protocolos.dta_cadastro' => $this->search,
            'protocolos.dta_atualizacao' => $this->search,
           
        ]);

        

        return $dataProvider;
    }
}
