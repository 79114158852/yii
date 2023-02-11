<?php

namespace app\models\user;

use Yii;
use yii\base\Model;
use app\models\User\Users;
//use app\models\User\UsersQuery;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends Model
{
    public string $email = '';
    public string $password = '';
    public string $password_hash = '';
    public bool $remember = true;
    private $currentUser = false;


    /**
     * @return array the validation rules.
    */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['remember', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword(string $attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect email or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {   
        $this->password = md5($this->password);
        if ($this->validate()) {
            return Yii::$app->user->login(Users::validateLogin($this->email, $this->password), $this->remember ? 3600*24*30 : 0);
        }
        return false;
    }

    public function getUser()
    {
        if ($this->currentUser === false) {
            $this->currentUser = Users::validateLogin($this->email, $this->password, PASSWORD_DEFAULT);
        }

        return $this->currentUser;
    }
   
}