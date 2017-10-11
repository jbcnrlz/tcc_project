<?php

namespace app\models;

/**
 * This is the model class for table "relatorio_parcial".
 *
 * @property integer $id
 * @property integer $fase
 * @property string $descricao
 * @property string $dataCadastro
 * @property string $nota
 * @property integer $projeto_id
 * @property integer $etapa_projeto
 * @property integer $apto
 * @property integer $status
 *
 * @property Projeto $projeto
 */
class RelatoriosParciais extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'relatorio_parcial';
    }
    
  

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fase', 'dataCadastro', 'projeto_id', 'etapa_projeto'], 'required'],
            [['fase', 'projeto_id', 'etapa_projeto', 'apto', 'status'], 'integer'],
            [['descricao'], 'string'],
            [['dataCadastro'], 'safe'],
            ['nota', 'required', 'when' => function ($model) {
                return $model->status == 1;
            }, 'whenClient' => "function (attribute, value) {
                return $('#status').val() == 1;
            }"],
            [['nota'], 'number','max'=>10]
        ];
    }
    
     public function nota($attribute){
        if(Projeto::find()->where(['and',['matricula_ra'=>$this->matricula_ra,'status'=>1]])->exists()){
                 $this->addError($attribute,'RA não perminitido, pois já existe um projeto em processo!');
                 return false;
             }else{
                 return true;
        }
       
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fase' => 'Fase',
            'descricao' => 'Atividade Desenvolvidas',
            'dataCadastro' => 'Data Cadastro',
            'nota' => 'Nota',
            'projeto_id' => 'Projeto ID',
            'etapa_projeto' => 'Etapa Projeto',
            'apto' => 'Apto',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjeto()
    {
        return $this->hasOne(Projeto::className(), ['id' => 'projeto_id']);
    }

                                                                            }
