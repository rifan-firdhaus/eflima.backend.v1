<?php namespace eflima\core\models\queries;

// "Keep the essence of your code, code isn't just a code, it's an art." -- Rifan Firdhaus Widigdo
use eflima\core\models\OAuth2Client;

/**
 * @author Rifan Firdhaus Widigdo <rifanfirdhaus@gmail.com>
 *
 * This is the ActiveQuery class for [[\eflima\core\models\OAuth2Client]].
 *
 * @see    \eflima\core\models\OAuth2Client
 */
class OAuth2ClientQuery extends \eflima\core\db\ActiveQuery
{
    /**
     * @inheritdoc
     *
     * @return OAuth2Client[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     *
     * @return OAuth2Client|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
