<?php namespace eflima\core\models;

// "Keep the essence of your code, code isn't just a code, it's an art." -- Rifan Firdhaus Widigdo

use eflima\core\db\ActiveQuery;
use eflima\core\db\ActiveRecord;
use eflima\core\models\queries\AccountQuery;
use eflima\core\models\queries\OAuth2AuthorizationCodeQuery;
use eflima\core\models\queries\OAuth2ClientQuery;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * @author Rifan Firdhaus Widigdo <rifanfirdhaus@gmail.com>
 *
 * @property Account      $account
 * @property OAuth2Client $client
 *
 * @property int          $id         [int(10) unsigned]
 * @property string       $client_id  [varchar(64)]
 * @property int          $account_id [int(11) unsigned]
 * @property string       $code
 * @property string       $redirect_uri
 * @property bool         $is_used    [tinyint(1)]
 * @property string       $scope      [varchar(255)]
 * @property int          $expiration [int(11) unsigned]
 * @property int          $used_at    [int(11) unsigned]
 * @property int          $created_at [int(11) unsigned]
 */
class OAuth2AuthorizationCode extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%oauth2_authorization_code}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [
                ['client_id', 'account_id', 'code', 'redirect_uri', 'expiration'],
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'client_id' => Yii::t('app', 'Client ID'),
            'account_id' => Yii::t('app', 'Account ID'),
            'code' => Yii::t('app', 'Code'),
            'redirect_uri' => Yii::t('app', 'Redirect Uri'),
            'is_used' => Yii::t('app', 'Is Used'),
            'scope' => Yii::t('app', 'Scope'),
            'expiration' => Yii::t('app', 'Expiration'),
            'used_at' => Yii::t('app', 'Used At'),
        ];
    }

    /**
     * @return ActiveQuery|AccountQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::class, ['id' => 'account_id'])
            ->inverseOf('authorizationCodes');
    }

    /**
     * @return ActiveQuery|OAuth2ClientQuery
     */
    public function getClient()
    {
        return $this->hasOne(OAuth2Client::class, ['id' => 'client_id'])
            ->inverseOf('authorizationCodes');
    }

    /**
     * @inheritDoc
     *
     * @return OAuth2AuthorizationCodeQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new OAuth2AuthorizationCodeQuery(get_called_class());

        return $query->alias("oauth2_authorization_code");
    }
}
