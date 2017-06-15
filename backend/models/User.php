<?php
namespace backend\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface{

    public $password;//保存密码的明文
    /*
     * 定义场景
     */
    const SCENARIO_ADD = 'add';
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            ['password','required','on'=>self::SCENARIO_ADD],
            //限制密码长度8-32位
            ['password','string','length'=>[8,32],'tooShort'=>'密码太短了'],
            [['status', 'created_at', 'updated_at', 'end_time'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['ip_end'], 'string', 'max' => 15],
            [['username'], 'unique'],//on指定验证规则生效场景
            [['email'], 'unique'],
            [['email'], 'email'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'auth_key' => 'Auth Key',
            'password' => '密码',
            'password_reset_token' => 'Password Reset Token',
            'email' => '电子邮箱',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'end_time' => '最后登录时间',
            'ip_end' => 'ip_end',
        ];
    }

    public function beforeSave($insert)
    {
        if($insert){
            $this->created_at = time();
            $this->status = 1;
            //生成随机字符串
            $this->auth_key = \Yii::$app->security->generateRandomString();
        }
        if($this->password){
            $this->password_hash = \Yii::$app->security->generatePasswordHash($this->password);
        }
        return parent::beforeSave($insert);
    }
    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        // TODO: Implement getId() method.
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}