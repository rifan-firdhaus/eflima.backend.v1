<?php namespace eflima\core\models;

// "Keep the essence of your code, code isn't just a code, it's an art." -- Rifan Firdhaus Widigdo

use eflima\core\db\ActiveQuery;
use eflima\core\db\ActiveRecord;
use eflima\core\models\queries\AccountQuery;
use eflima\core\models\queries\OAuth2AccessTokenQuery;
use eflima\core\models\queries\OAuth2ClientQuery;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * @author Rifan Firdhaus Widigdo <rifanfirdhaus@gmail.com>
 *
 * @property Account      $account
 * @property OAuth2Client $client
 *
 * @property int          $id               [int(10) unsigned]
 * @property string       $client_id        [varchar(64)]
 * @property string       $account_id       [char(16)]
 * @property string       $token
 * @property int          $expiration       [int(11) unsigned]
 * @property bool         $is_granted       [tinyint(1)]
 * @property string       $scope            [varchar(255)]
 * @property int          $last_activity_at [int(11) unsigned]
 * @property int          $created_at       [int(11) unsigned]
 */
class OAuth2AccessToken extends ActiveRecord
{
    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [
                ['client_id', 'account_id', 'token', 'expiration'],
                'required',
            ],
            [
                ['expiration'],
                'integer',
            ],
            [
                ['account_id'],
                'exist',
                'targetRelation' => 'account',
            ],
            [
                ['client_id'],
                'exist',
                'targetRelation' => 'client',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%oauth2_access_token}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'client_id' => Yii::t('app', 'Client ID'),
            'account_id' => Yii::t('app', 'Account ID'),
            'token' => Yii::t('app', 'Token'),
            'expiration' => Yii::t('app', 'Expiration'),
            'is_granted' => Yii::t('app', 'Is Granted'),
            'scope' => Yii::t('app', 'Scope'),
            'last_activity_at' => Yii::t('app', 'Last Activity At'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['timestamp'] = [
            'class' => TimestampBehavior::class,
            'updatedAtAttribute' => false,
        ];

        return $behaviors;
    }

    /**
     * @return ActiveQuery|AccountQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::class, ['id' => 'account_id'])->inverseOf('OAuth2AccessTokens');
    }

    /**
     * @return ActiveQuery|OAuth2ClientQuery
     */
    public function getClient()
    {
        return $this->hasOne(OAuth2Client::class, ['id' => 'client_id'])->inverseOf('OAuth2AccessTokens');
    }

    /**
     * @inheritDoc
     *
     * @return OAuth2AccessTokenQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new OAuth2AccessTokenQuery(get_called_class());

        return $query->alias("oauth2_access_token");
    }
}
