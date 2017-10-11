<?php

namespace app\models;
use app\behaviors\LoggableBehavior;


/**
 * This is the model class for table "matricula".
 *
 * @property string $ra
 * @property integer $curso_id
 * @property integer $ano
 * @property integer $semestre
 * @property string $periodo
 * @property integer $termo
 * @property integer $estudante_id
 * @property integer $instituicao_id
 * @property integer $status
 * @property integer $etapa_projeto
 *
 * @property DtaProtocolar[] $dtaProtocolars
 * @property Estudante[] $estudantes
 * @property Curso $curso
 * @property Instituicao $instituicao
 * @property Usuario $estudante
 * @property ArquivosProjetos[] $arquivosProjetos
 * @property RelatorioParcial[] $relatorioParcials
 */
class Matricula extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
   
    public static function tableName()
    {
        return 'matricula';
    }
    
   public function behaviors()
     {
		return [
                    [
                        'class' => LoggableBehavior::className(),
                    ],
		];
     }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ra', 'curso_id','instituicao_id','etapa_projeto','termo','periodo'], 'required'],
            [['curso_id', 'ano', 'semestre', 'termo', 'estudante_id', 'instituicao_id', 'status', 'etapa_projeto'], 'integer'],
            [['ra'], 'string', 'max' => 13],
            [['ra'],'number'],
            ['ra', 'validacao_ra'],
            [['periodo'], 'string', 'max' => 45],
            [['ra'], 'unique']
        ];
    }
    
    public function validacao_ra($attribute){
        if(!empty($this->instituicao_id) && !empty($this->curso_id)){
             if(!Instituicao::find()->where(['id'=>$this->instituicao_id])->exists() || !Curso::find()->where(['id'=>$this->curso_id])->exists()){
                 $this->addError($attribute,'RA inválido, verifique os números digitados.');
                 return false;
             }else{
                 return true;
             }
       }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ra' => 'RA',
            'curso_id' => 'Curso',
            'ano' => 'Ano',
            'semestre' => 'Semestre',
            'periodo' => 'Período',
            'termo' => 'Termo Atual',
            'estudante_id' => 'Estudante',
            'instituicao_id' => 'Instituicao',
            'status' => 'Status',
            'etapa_projeto' => 'Etapa Atual Projeto',
        ];
    }
    
    public function getPeriodos(){
        return ['Matutino' => 'Matutino', 'Vespertino' => 'Vespertino', 'Noturno' => 'Noturno', 'EAD' => 'EAD'];
    }
    
    public function getTermos(){
        return ['4' => '4º-Termo', '5' => '5º-Termo', '6' => '6º-Termo'];
    }
    
    /**
     * Adds a new error to the specified attribute.
     */
    public function getEtapas(){
        return ['1' => 'Projeto de Pesquisa', '2' => 'Trabalho de Graduação I', '3' => 'Trabalho de Graduação II', '4' => 'Graduado'];
    }
    
    public function getEtapasApresentacao(){
        return ['2' => 'Trabalho de Graduação I', '3' => 'Trabalho de Graduação II'];
    }
    
    public function getNomeEtapa($idEtapa = null){
        return $this->etapa_projeto = $this->etapas[($idEtapa != null)?$idEtapa:$this->etapa_projeto];
    }
    
    public function getNomeTermo(){
         return $this->termo = $this->termos[$this->termo];
    }
  

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDtaProtocolars()
    {
        return $this->hasMany(DtaProtocolar::className(), ['matricula_ra' => 'ra']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurso()
    {
        return $this->hasOne(Curso::className(), ['id' => 'curso_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstituicao()
    {
        return $this->hasOne(Instituicao::className(), ['id' => 'instituicao_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudante()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'estudante_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArquivosProjetos()
    {
        return $this->hasMany(ArquivosProjeto::className(), ['matricula_ra' => 'ra']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelatorioParcials()
    {
        return $this->hasMany(RelatorioParcial::className(), ['matricula_ra' => 'ra']);
    }

                                                                                    }
