<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class CalendarioAcademicoProcurar extends CalendarioAcademico
{
    public $search;
    public function rules()
    {
        return [
            [['id', 'badge', 'recorrencias'], 'integer'],
            [['title', 'body', 'footer', 'date', 'classname', 'curso_id'], 'safe'],
            [['search'],'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CalendarioAcademico::find()->indexBy('id');

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
            'badge' => $this->search,
            'date' => $this->search,
            'recorrencias' => $this->search,
        ]);

        $query->orFilterWhere(['like', 'title', $this->search])
            ->orFilterWhere(['like', 'body', $this->search])
            ->orFilterWhere(['like', 'footer', $this->search])
            ->orFilterWhere(['like', 'classname', $this->search])
            ->orFilterWhere(['like', 'curso_id', $this->search]);

        return $dataProvider;
    }
}
