<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
//            ['email', 'exist',
//                'targetClass' => 'app\models\Usuario',
//                'filter' => ['status' => Usuario::STATUS_ACTIVE],
//                'message' => 'Não foi encontrado nenhum cadastro com este E-mail'
//            ],
            ['email', 'exist',
                'targetClass' => 'app\models\Usuario',
                'filter' => ['status' => [Usuario::STATUS_BLOCKED,Usuario::STATUS_ACTIVE, Usuario::STATUS_PENDING]],
                'message' => 'Este e-mail não esta cadastrado'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = Usuario::findOne([
            'status' => Usuario::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!Usuario::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
        }
        
        if (!$user->save()) {
            return false;
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'redefinirSenhaToken'],
                ['user' => $user]
            )
            ->setFrom([\Yii::$app->params['e-mail-contato-cadastro'] => \Yii::$app->name])
            ->setTo($this->email)
            ->setSubject('Redefinição da Senha :: '.Yii::$app->params['instituicao'])
            ->send();
    }
}
