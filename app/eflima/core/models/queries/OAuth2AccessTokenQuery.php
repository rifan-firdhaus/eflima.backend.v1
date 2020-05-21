<?php namespace eflima\core\models\queries;

// "Keep the essence of your code, code isn't just a code, it's an art." -- Rifan Firdhaus Widigdo

/**
* @author Rifan Firdhaus Widigdo
<rifanfirdhaus@gmail.com>
*
* This is the ActiveQuery class for [[\eflima\core\models\OAuth2AccessToken]].
*
* @see \eflima\core\models\OAuth2AccessToken
*/
class OAuth2AccessTokenQuery extends \eflima\core\db\ActiveQuery
{
/**
* @inheritdoc
* @return \eflima\core\models\OAuth2AccessToken[]|array
*/
public function all($db = null)
{
return parent::all($db);
}

/**
* @inheritdoc
* @return \eflima\core\models\OAuth2AccessToken|array|null
*/
public function one($db = null)
{
return parent::one($db);
}
}
