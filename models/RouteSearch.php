<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RouteSearch represents the model behind the search form about `app\modules\seguranca\models\Route`.
 */
class RouteSearch extends Route
{
	/**
	 * @inheritdoc
	 */
    
        public $search;
	public function rules()
	{
		return [
			[['name', 'alias', 'type', 'search'], 'safe'],
			[['status'], 'integer'],
                        
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
		$query = Route::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

                
                 if (!($this->load($params) && $this->validate())) {
                    return $dataProvider;
                }
	

		if (!$this->validate()) {
		
			return $dataProvider;
		}

                if($this->search == null){
                    $query->orFilterWhere([
                            'status' => $this->status,
                    ]);
                 };

		$query->orFilterWhere(['like', 'name', $this->search])
			->orFilterWhere(['like', 'alias', $this->search])
			->orFilterWhere(['like', 'type', $this->search]);

		return $dataProvider;
	}
}
