<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ApresentacaoProcurar represents the model behind the search form about `app\models\Apresentacao`.
 */
class ApresentacaoProcurar extends Apresentacao
{
    /**
     * @inheritdoc
     */
    
    public $search;
    
    public function rules()
    {
        return [
            [['id', 'resultado_aprovacao', 'status', 'orientador_id', 'convidado_primario_id', 'convidado_secundario_id', 'etapa_projeto', 'projeto_id'], 'integer'],
            [['dta_apresentacao', 'periodo', 'horario', 'local', 'dta_versao_final', 'dta_cadastro', 'curso_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Apresentacao::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
               'defaultOrder'=>[
                   'dta_apresentacao'=>SORT_ASC,
                   'horario'=>SORT_ASC
               ],
            ],
            'pagination' => [
                  'pageSize' => 40,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->orFilterWhere([            
            'curso_id' => $this->curso_id,
            'etapa_projeto' => $this->etapa_projeto,
            'periodo' => $this->periodo,
        ]);


        return $dataProvider;
    }
    
    public function searchBanca($params)
    {
        $query = Apresentacao::find();
        $query->where("orientador_id = ".Yii::$app->user->id." OR ".
                      "convidado_primario_id = ".Yii::$app->user->id." OR ".
                      "convidado_secundario_id = ".Yii::$app->user->id
           
        );
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
               'defaultOrder'=>[
                   'dta_apresentacao'=>SORT_ASC,
                   'horario'=>SORT_ASC
               ],
            ],
            'pagination' => [
                  'pageSize' => 40,
            ],
        ]);
        
        
        

        if (!($this->load($params) && $this->validate())) {
//            return $dataProvider;
        }

    
        $query->andFilterWhere([ 
            'status' => $this->status==''?1:$this->status,            
            'curso_id' => $this->curso_id,
            'etapa_projeto' => $this->etapa_projeto,
            'periodo' => $this->periodo,
           
        ]);
        
//        $query->orFilterWhere([
////           ['=','matricula.curso_id',$this->curso_id]
//        ]);


        return $dataProvider;
    }
}
