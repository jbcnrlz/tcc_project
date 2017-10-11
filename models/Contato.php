<?php

namespace app\models;

use app\behaviors\LoggableBehavior;

class Contato extends \yii\base\Model
{
  
    public $nome;
    public $email;
    public $assunto;
    public $descricao;
    public $status;
    public $telefone;
    public $celular;
    public $captcha;
    
      public function behaviors()
     {
		return [
                    [
                        'class' => LoggableBehavior::className(),
                    ],
		];
     }
    
    public function rules()
    {
        return [
            [['nome', 'email', 'assunto', 'descricao'], 'required'],
            [['descricao'], 'string'],
            ['email','email'],
            [['nome', 'email'], 'string', 'max' => 80],
            [['assunto'], 'string', 'max' => 200],
            [['telefone', 'celular'], 'string', 'max' => 45],
            ['captcha', 'required'],
            ['captcha', 'captcha']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nome' => 'Nome',
            'email' => 'E-mail',
            'telefoneFixo' => 'Telefone',
            'celularComercial' => 'Celular',
            'assunto' => 'Assunto',
            'descricao' => 'Descrição',
            'dataCadastro' => 'Data Cadastro',
            'captcha'=>'Digite as Letras'
       ];
    }
}
