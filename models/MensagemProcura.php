<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class MensagemProcura extends Mensagem
{
    public $search;
    public function rules()
    {
        return [
            [['id', 'destinatario_id', 'remetente_id', 'prioridade', 'lido', 'status'], 'integer'],
            [['assunto', 'mensagem', 'dta_cadastro', 'dta_atualizacao'], 'safe'],
            [['search'],'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Mensagem::find()->indexBy('id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
               'defaultOrder'=>[
                   'dta_cadastro'=>SORT_DESC
               ],
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
            'destinatario_id' => Yii::$app->user->id,
            'remetente_id' => $this->search,
            'prioridade' => $this->search,
            'lido' => $this->search,
            'status' => $this->search,
            'dta_cadastro' => $this->search,
            'dta_atualizacao' => $this->search,
        ]);

        $query->orFilterWhere(['like', 'assunto', $this->search])
            ->orFilterWhere(['like', 'mensagem', $this->search]);

        return $dataProvider;
    }
}
