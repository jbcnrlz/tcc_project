<?php

namespace app\models;

use app\behaviors\LoggableBehavior;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yiibr\brvalidator\CpfValidator;


/**
 * User model
 *
 * @property integer $id
 * @property string $nome
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property datetime $dta_cadastro
 * @property datetime $ultimo_acesso
 * @property datetime $dta_atualizacao
 * @property string $password write-only password
 */
class Usuario extends ActiveRecord implements IdentityInterface
{
    const STATUS_BLOCKED  = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_PENDING  = 2;

    public $new_password, $old_password, $repeat_password, $confirmacao;
   
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%usuario}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
       
        return [
            [
                 'class'=> TimestampBehavior::className(),
                 'createdAtAttribute'=>'dta_cadastro',
                 'updatedAtAttribute'=>'dta_atualizacao',
                 'value' => function() { 
                        return date('Y-m-d H:i:s');
                  },
            ],
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
            [['nome', 'username', 'email', 'cpf', 'tipo', 'password_hash','sexo'], 'required'],
            [['nome', 'username', 'email', 'cpf', 'tipo','confirmacao'], 'required', 'on'=>'cadastro-estudante'],
            ['cpf', CpfValidator::className(),'on'=>'cadastro-estudante'],
            [['cpf'],'string','min'=>14, 'tooShort'=>'Verifique o CPF digitado (Ex.:000.000.000-00)'],
            [['cpf'],'string','min'=>14, 'tooShort'=>'Verifique o CPF digitado (Ex.:000.000.000-00)','on'=>'cadastro-estudante'],
            [['username', 'email','foto', 'password_hash'], 'string', 'max' => 255],
            [['username','cpf', 'email'], 'unique'],
            ['cpf', CpfValidator::className()],
         
            [['username'], 'match', 'pattern' => '/^[A-Za-z0-9-]+$/','message'=>'Não é permitido espaço ou caracteres especiais'],
            [['email'], 'email'],
            [['lattes'],'url'],
            [['lattes'],'required','when'=>function($model){
                return ($model->tipo == 'Professor');
            }, 'whenClient' => "function (attribute, value) {
                return ($('#usuario-tipo').val() == 'Professor' && $('#usuario-tipo').val() != '');
                }"],
            [['dta_expiracao'],'required','when'=>function($model){
                return (($model->tipo == 'Aluno' && $model->tipo !=""));
            }, 'whenClient' => "function (attribute, value) {
                return ($('#usuario-tipo').val() == 'Aluno' && $('#usuario-tipo').val() != '');
                }"],
                     
            [['dta_expiracao'],'compare','compareValue'=>date('Y-m-d'),'operator'=>'>','message'=>'"Data Expiração" deve ser superior a data de hoje', 'when'=>function($model){
                return ($model->status != 0);
             }, 'whenClient'=>"function(attribute,value){
                     return($('#usuario-status').val()!=0);
                }"        
            ],
          
            [['status','notificacao'],'integer'],
            
            [['old_password','new_password', 'repeat_password'], 'string', 'min' => 6],
            [['repeat_password'], 'compare', 'compareAttribute' => 'new_password'],
            [['new_password', 'repeat_password'], 'required', 'when' => function ($model) {
                return (!empty($model->new_password));
            }, 'whenClient' => "function (attribute, value) {
                return ($('#usuario-new_password').val().length>0);
            }"],
         ];
    }
    
   
    public function getApresentacaos() 
    { 
        return $this->hasMany(Apresentacao::className(), ['convidado_primario_id' => 'id']);
    } 

    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getAuditlogs() 
    { 
        return $this->hasMany(Auditlog::className(), ['user_id' => 'id']);
    } 

    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getAutorizacaoAtribuicoes() 
    { 
        return $this->hasMany(AutorizacaoAtribuicoes::className(), ['user_id' => 'id']);
    } 

    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getItemNames() 
    { 
        return $this->hasMany(AutorizacaoItem::className(), ['name' => 'item_name'])->viaTable('autorizacao_atribuicoes', ['user_id' => 'id']);
    } 

    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getComentariosTarefas() 
    { 
        return $this->hasMany(ComentariosTarefas::className(), ['user_id' => 'id']);
    } 

    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getCorreios() 
    { 
        return $this->hasMany(Correios::className(), ['remetente_id' => 'id']);
    } 

    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getMatriculas() 
    { 
        return $this->hasMany(Matricula::className(), ['estudante_id' => 'id']);
    } 
    
     /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getMatriculasAtiva() 
    { 
        return $this->hasOne(Matricula::className(), ['estudante_id' => 'id'])->andOnCondition(['status'=>1]);
    } 

    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getOrientadors() 
    { 
        return $this->hasMany(Orientador::className(), ['professor_id' => 'id']);
    } 

    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getTarefas() 
    { 
        return $this->hasMany(Tarefas::className(), ['user_autor_id' => 'id']);
    } 

        public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['password'] = ['old_password', 'new_password', 'repeat_password'];
        return $scenarios;
    }
    
   
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Usuário',
            'password_hash' => 'Senha',
            'nome'=>'Nome',
            'ra'=>'RA',
            'tipo'=>'Tipo',
            'cpf'=>'CPF',
            'lattes'=>'Curriculo Lattes',
            'pesquisa'=>'Linha de Pesquisa',
            'foto'=>'Foto do Perfil',
            'email' => 'E-mail',
            'dta_cadastro' => 'Cadastro',
            'dta_atualizacao' => 'Atualização',
            'dta_expiracao' => 'Data Expiração',
            'old_password'=>'Senha Atual',
            'new_password'=>'Nova Senha',
            'repeat_password'=>'Repita a Senha',
            'confirmacao'=>'Confirmo que os dados estão corretos'
        ];
    }
    

    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }


    public static function findByEmail($email){
        return static::findOne(['email'=>$email, 'status'=> self::STATUS_ACTIVE]);
    }
    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['usuario.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }


    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


    public function getRoles()
    {
        return $this->hasMany(AuthAssignment::className(), [
            'user_id' => 'id',
        ]);
    }
}
