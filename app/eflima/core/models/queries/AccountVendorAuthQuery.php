<?php namespace eflima\core\models\queries;

// "Keep the essence of your code, code isn't just a code, it's an art." -- Rifan Firdhaus Widigdo

/**
* @author Rifan Firdhaus Widigdo
<rifanfirdhaus@gmail.com>
*
* This is the ActiveQuery class for [[\eflima\core\models\AccountVendorAuth]].
*
* @see \eflima\core\models\AccountVendorAuth
*/
class AccountVendorAuthQuery extends \eflima\core\db\ActiveQuery
{
/**
* @inheritdoc
* @return \eflima\core\models\AccountVendorAuth[]|array
*/
public function all($db = null)
{
return parent::all($db);
}

/**
* @inheritdoc
* @return \eflima\core\models\AccountVendorAuth|array|null
*/
public function one($db = null)
{
return parent::one($db);
}
}
