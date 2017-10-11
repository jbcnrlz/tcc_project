<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class DtaProtocolarProcurar extends DtaProtocolar
{
    public $search;
    public function rules()
    {
        return [
            [['id', 'etapa_projeto'], 'integer'],
            [['dta_inicio', 'dta_termino', 'curso_id', 'matricula_ra', 'observacao'], 'safe'],
            [['search'],'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = DtaProtocolar::find()->indexBy('id');

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
            'dta_inicio' => $this->search,
            'dta_termino' => $this->search,
            'etapa_projeto' => $this->search,
        ]);

        $query->orFilterWhere(['like', 'curso_id', $this->search])
            ->orFilterWhere(['like', 'matricula_ra', $this->search])
            ->orFilterWhere(['like', 'observacao', $this->search]);

        return $dataProvider;
    }
}
