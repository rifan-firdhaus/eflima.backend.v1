<?php namespace eflima\core\models;

// "Keep the essence of your code, code isn't just a code, it's an art." -- Rifan Firdhaus Widigdo

use eflima\core\db\ActiveQuery;
use eflima\core\db\ActiveRecord;
use eflima\core\models\queries\OAuth2AuthorizationCodeQuery;
use eflima\core\models\queries\OAuth2ClientQuery;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * @author Rifan Firdhaus Widigdo <rifanfirdhaus@gmail.com>
 *
 * @property OAuth2AccessToken[]       $accessTokens
 * @property OAuth2AuthorizationCode[] $authorizationCodes
 *
 * @property string                    $id               [varchar(64)]
 * @property string                    $client_secret    [varchar(64)]
 * @property bool                      $is_public        [tinyint(1)]
 * @property int                       $last_activity_at [int(11) unsigned]
 * @property int                       $created_at       [int(11) unsigned]
 */
class OAuth2Client extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%oauth2_client}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'client_secret' => Yii::t('app', 'Client Secret'),
            'last_activity_at' => Yii::t('app', 'Last Activity At'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }


    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['timestamp'] = [
            'class' => TimestampBehavior::class,
        ];

        return $behaviors;
    }

    /**
     * @return ActiveQuery
     */
    public function getAccessTokens()
    {
        return $this->hasMany(OAuth2AccessToken::class, ['client_id' => 'id'])
            ->inverseOf('client');
    }

    /**
     * @return ActiveQuery|OAuth2AuthorizationCodeQuery
     */
    public function getAuthorizationCodes()
    {
        return $this->hasMany(OAuth2AuthorizationCode::class, ['client_id' => 'id'])
            ->inverseOf('client');
    }

    /**
     * @inheritDoc
     *
     * @return OAuth2ClientQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \eflima\core\models\queries\OAuth2ClientQuery(get_called_class());

        return $query->alias("o_auth2client");
    }
}
