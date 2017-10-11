<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
     public $repeat_password;

    /**
     * @var \common\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param  string                          $token
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
             Yii::$app->session->setFlash('error', 'Token de redefinição de senha não pode ficar ser vazio');
             return  Yii::$app->getResponse()->redirect(['/']);
      
           // throw new InvalidParamException('Password reset token cannot be blank.');
        }
        $this->_user = Usuario::findByPasswordResetToken($token);
        if (!$this->_user) {
              Yii::$app->session->setFlash('error', 'Token de redefinação de senha inválido!');
              return  Yii::$app->getResponse()->redirect(['/']);
           // throw new InvalidParamException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password','repeat_password'], 'required'],
            [['repeat_password'], 'compare', 'compareAttribute' => 'password','message'=>'As senhas não coincidem'],
            ['password', 'string', 'min' => 6],
        ];
    }

     public function attributeLabels() {
        return[
            'password' => 'Nova senha'
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
