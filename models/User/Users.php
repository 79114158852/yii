<?php

namespace app\models\User;
 
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $username
 * @property string $role
 * @property int $active
 *
 * @property History[] $histories
 */
class Users extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }





/**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password', 'username'], 'required'],
            [['role'], 'string'],
            [['active'], 'integer'],
            [['email', 'password', 'username'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'active' => 'Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Histories]].
     *
     * @return \yii\db\ActiveQuery|HistoryQuery
     */
    public function getHistories()
    {
        return $this->hasMany(History::class, ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'active' => '1']);
    }

     /**
     * @inheritdoc
     */
    public static function getById($id)
    {
        return static::findOne(['id' => $id]);
    }
  
    
    /**
     * {@inheritdoc}
    */
    public static function validateLogin($email, $password_hash)
    {
        return self::findOne(['email' => $email, 'password' => $password_hash, 'active' => 1]);
    }    

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool|null if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }


    /**
     * generate an auth key
    */
    public function beforeSave($insert)
    {
        
        if ($this->isNewRecord || $this->password != Yii::$app->request->post()['current_password']){

            $this->password = md5($this->password);

        }
        
        $this->active = isset(Yii::$app->request->post()['active']) ? 1 : 0;

        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, Yii::$app->getSecurity()->generatePasswordHash($password));
    }

}