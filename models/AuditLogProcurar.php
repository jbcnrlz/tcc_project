<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class AuditLogProcurar extends AuditLog
{
    public $search;
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['model', 'acao', 'antigo', 'novo', 'ip', 'data'], 'safe'],
            [['search'],'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = AuditLog::find()->indexBy('id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder'=>[
                       'data'=> SORT_DESC,
                ]
            ],
            'pagination' => [
                  'pageSize' => Yii::$app->params['pageSize'],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->orFilterWhere([
            'id' => $this->search,
            'data' => $this->search,
            'user_id' => $this->search,
        ]);

        $query->orFilterWhere(['like', 'model', $this->search])
            ->orFilterWhere(['like', 'acao', $this->search])
            ->orFilterWhere(['like', 'antigo', $this->search])
            ->orFilterWhere(['like', 'novo', $this->search])
            ->orFilterWhere(['like', 'ip', $this->search]);

        return $dataProvider;
    }
}
