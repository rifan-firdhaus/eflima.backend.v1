<?php namespace eflima\core\models;

// "Keep the essence of your code, code isn't just a code, it's an art." -- Rifan Firdhaus Widigdo

use eflima\core\db\ActiveQuery;
use eflima\core\db\ActiveRecord;
use eflima\core\models\queries\AccountQuery;
use eflima\core\models\queries\AccountVendorAuthQuery;
use Yii;

/**
 * @author Rifan Firdhaus Widigdo <rifanfirdhaus@gmail.com>
 *
 * @property Account $account
 *
 * @property int     $id         [int(10) unsigned]
 * @property string  $account_id [char(16)]
 * @property string  $vendor     [varchar(32)]
 * @property string  $access_token
 * @property string  $data
 * @property int     $expiration [int(11) unsigned]
 * @property int     $created_at [int(11) unsigned]
 */
class AccountVendorAuth extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_vendor_auth}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'vendor', 'access_token'], 'required'],
            [['access_token', 'data'], 'string'],
            [['expiration', 'created_at'], 'integer'],
            [['account_id'], 'string', 'max' => 16],
            [['vendor'], 'string', 'max' => 32],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::class, 'targetAttribute' => ['account_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'account_id' => Yii::t('app', 'Account ID'),
            'vendor' => Yii::t('app', 'Vendor'),
            'access_token' => Yii::t('app', 'Access Token'),
            'data' => Yii::t('app', 'Data'),
            'expiration' => Yii::t('app', 'Expiration'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return ActiveQuery|AccountQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::class, ['id' => 'account_id'])
            ->inverseOf('vendorAuths');
    }

    /**
     * @inheritDoc
     *
     * @return AccountVendorAuthQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new AccountVendorAuthQuery(get_called_class());

        return $query->alias("account_vendor_auth");
    }
}
