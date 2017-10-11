<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;


class ConfiguracaoAppProcurar extends ConfiguracaoApp
{
    public $search;
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['descricao', 'nome', 'valor'], 'safe'],
            [['search'],'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ConfiguracaoApp::find()->indexBy('id');
        
        $query->where('id NOT IN (15)');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder'=>[
                    'ordem'=>SORT_ASC,
                ]
            ],
            'pagination' => [
                  'pageSize' => 30,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->orFilterWhere([
            'id' => $this->search,
        ]);

        $query->orFilterWhere(['like', 'descricao', $this->search])
            ->orFilterWhere(['like', 'nome', $this->search])
            ->orFilterWhere(['like', 'valor', $this->search]);

        return $dataProvider;
    }
}
