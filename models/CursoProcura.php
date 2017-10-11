<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class CursoProcura extends Curso
{
    public $search;
    public function rules()
    {
        return [
            [['id', 'nome', 'nome_abreviado'], 'safe'],
            [['status'], 'integer'],
            [['search'],'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Curso::find()->indexBy('id');

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
            'status' => $this->search,
        ]);

        $query->orFilterWhere(['like', 'id', $this->search])
            ->orFilterWhere(['like', 'nome', $this->search])
            ->orFilterWhere(['like', 'nome_abreviado', $this->search]);

        return $dataProvider;
    }
}
