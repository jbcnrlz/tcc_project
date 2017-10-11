<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class MatriculaProcurar extends Matricula
{
    public $search;
    public function rules()
    {
        return [
            [['ra', 'curso_id', 'periodo', 'instituicao_id'], 'safe'],
            [['ano', 'semestre', 'termo', 'estudante_id', 'status', 'etapa_projeto'], 'integer'],
            [['search'],'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Matricula::find()->indexBy('id');

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
            'ano' => $this->search,
            'semestre' => $this->search,
            'termo' => $this->search,
            'estudante_id' => $this->search,
            'status' => $this->search,
            'etapa_projeto' => $this->search,
        ]);

        $query->orFilterWhere(['like', 'ra', $this->search])
            ->orFilterWhere(['like', 'curso_id', $this->search])
            ->orFilterWhere(['like', 'periodo', $this->search])
            ->orFilterWhere(['like', 'instituicao_id', $this->search]);

        return $dataProvider;
    }
}
