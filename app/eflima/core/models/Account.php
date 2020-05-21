<?php namespace eflima\core\models;

// "Keep the essence of your code, code isn't just a code, it's an art." -- Rifan Firdhaus Widigdo

use eflima\core\Core;
use eflima\core\db\ActiveQuery;
use eflima\core\db\ActiveRecord;
use eflima\core\models\queries\AccountQuery;
use eflima\core\models\queries\AccountVendorAuthQuery;
use eflima\core\models\queries\OAuth2AccessTokenQuery;
use eflima\core\models\queries\OAuth2AuthorizationCodeQuery;
use Ramsey\Uuid\Uuid;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * @author Rifan Firdhaus Widigdo <rifanfirdhaus@gmail.com>
 *
 *
 * @property AccountVendorAuth[]       $vendorAuths
 * @property OAuth2AccessToken[]       $accessTokens
 * @property OAuth2AuthorizationCode[] $authorizationCodes
 * @property string                    $authKey
 *
 * @property int                       $id                             [int(10) unsigned]
 * @property string                    $uuid                           [char(36)]
 * @property string                    $username                       [varchar(255)]
 * @property string                    $email                          [varchar(255)]
 * @property string                    $phone
 * @property string                    $password
 * @property string                    $pasword_reset_token            [char(64)]
 * @property int                       $pasword_reset_token_expiration [int(11) unsigned]
 * @property string                    $auth_token                     [char(64)]
 * @property bool                      $is_blocked                     [tinyint(1) unsigned]
 * @property bool                      $is_system                      [tinyint(1) unsigned]
 * @property string                    $confirmation_token             [char(64)]
 * @property int                       $confirmation_expiration        [int(11) unsigned]
 * @property int                       $confirmed_at                   [int(11) unsigned]
 * @property int                       $last_active_at                 [int(11) unsigned]
 * @property int                       $created_at                     [int(11) unsigned]
 * @property int                       $updated_at                     [int(11) unsigned]
 */
class Account extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account}}';
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['timestamp'] = [
            'class' => TimestampBehavior::class,
        ];

        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'password' => Yii::t('app', 'Password'),
            'pasword_reset_token' => Yii::t('app', 'Pasword Reset Token'),
            'pasword_reset_token_expiration' => Yii::t('app', 'Pasword Reset Token Expiration'),
            'auth_token' => Yii::t('app', 'Auth Token'),
            'is_blocked' => Yii::t('app', 'Is Blocked'),
            'is_system' => Yii::t('app', 'Is System'),
            'confirmation_token' => Yii::t('app', 'Confirmation Token'),
            'confirmation_expiration' => Yii::t('app', 'Confirmation Expiration'),
            'confirmed_at' => Yii::t('app', 'Confirmed At'),
            'last_active_at' => Yii::t('app', 'Last Active At'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return ActiveQuery|AccountVendorAuthQuery
     */
    public function getVendorAuths()
    {
        return $this->hasMany(AccountVendorAuth::class, ['account_id' => 'id'])
            ->inverseOf('account');
    }

    /**
     * @return ActiveQuery|OAuth2AccessTokenQuery
     */
    public function getAccessTokens()
    {
        return $this->hasMany(OAuth2AccessToken::class, ['account_id' => 'id'])
            ->inverseOf('account');
    }

    /**
     * @return ActiveQuery|OAuth2AuthorizationCodeQuery
     */
    public function getAuthorizationCodes()
    {
        return $this->hasMany(OAuth2AuthorizationCode::class, ['account_id' => 'id'])
            ->inverseOf('account');
    }

    /**
     * @inheritDoc
     *
     * @return AccountQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new AccountQuery(get_called_class());

        return $query->alias("account");
    }

    /**
     * @inheritDoc
     */
    public function normalizeAttributes($save)
    {
        if ($save) {

            if (!empty($this->password) && $this->isAttributeChanged('password')) {
                $this->password = Yii::$app->security->generatePasswordHash($this->password);
            } else {
                $this->password = $this->getOldAttribute('password');
            }

            if ($this->getIsNewRecord()) {
                $this->uuid = Uuid::uuid4()->toString();

                if (empty($this->auth_token)) {
                    $this->auth_token = Yii::$app->security->generateRandomString(64);
                }
            }
        }

        parent::normalizeAttributes($save);
    }

    /**
     * @inheritDoc
     */
    public static function findIdentity($id)
    {
        return self::find()->andWhere(['id' => $id])
            ->andWhere(['is_blocked' => false])
            ->one();
    }

    /**
     * @inheritDoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /** @var Core $core */
        $core = Yii::$app->getModule('core');

        $token = $core->oauth2->storage->getAccessToken($token);

        if ($token === null) {
            return;
        }

        return self::findIdentity($token['user_id']);
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getAuthKey()
    {
        return $this->auth_token;
    }

    /**
     * @inheritDoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_token === $authKey;
    }

    /**
     * @param string $password
     *
     * @return bool
     */
    public function verifyPassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
}
