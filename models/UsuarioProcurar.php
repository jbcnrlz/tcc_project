<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class UsuarioProcurar extends Usuario
{
    public $search;
    public function rules()
    {
        return [
            [['id', 'status', 'dta_cadastro', 'dta_atualizacao'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email'], 'safe'],
            [['search'],'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Usuario::find()->indexBy('id')->joinWith('matriculas');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
               'defaultOrder'=>[
                   'status'=>SORT_DESC,
                   'nome'=>SORT_ASC
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
            'dta_cadastro' => $this->search,
            'dta_atualizacao' => $this->search,
            
        ]);

        $query->orFilterWhere(['like', 'username', $this->search])
            ->orFilterWhere(['like', 'auth_key', $this->search])
            ->orFilterWhere(['like', 'password_hash', $this->search])
            ->orFilterWhere(['like', 'password_reset_token', $this->search])
            ->orFilterWhere(['like', 'email', $this->search])
            ->orFilterWhere(['like', 'pesquisa', $this->search])
            ->orFilterWhere(['like', 'tipo', $this->search])
            ->orFilterWhere(['like', 'nome', $this->search])
            ->orFilterWhere(['like', 'ra', $this->search]);
           

        return $dataProvider;
    }
}
