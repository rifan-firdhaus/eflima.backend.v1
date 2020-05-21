<?php namespace eflima\core\models;

// "Keep the essence of your code, code isn't just a code, it's an art." -- Rifan Firdhaus Widigdo

use eflima\core\db\ActiveQuery;
use eflima\core\db\ActiveRecord;
use eflima\core\models\queries\AccountQuery;
use eflima\core\models\queries\AdministratorQuery;
use Yii;

/**
 * @author Rifan Firdhaus Widigdo <rifanfirdhaus@gmail.com>
 *
 * @property Account $account
 *
 * @property int     $id         [int(10) unsigned]
 * @property int     $account_id [int(11) unsigned]
 * @property string  $uuid       [char(36)]
 * @property string  $first_name
 * @property string  $last_name
 * @property string  $created_at
 * @property string  $updated_at
 */
class Administrator extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%administrator}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'account_id' => Yii::t('app', 'Account ID'),
            'uuid' => Yii::t('app', 'Uuid'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return ActiveQuery|AccountQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_id'])->inverseOf('administrators');
    }

    /**
     * @inheritDoc
     *
     * @return AdministratorQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new AdministratorQuery(get_called_class());

        return $query->alias("administrator");
    }
}
