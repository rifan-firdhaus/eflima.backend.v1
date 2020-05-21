<?php namespace eflima\core\models\queries;

// "Keep the essence of your code, code isn't just a code, it's an art." -- Rifan Firdhaus Widigdo
use eflima\core\db\ActiveQuery;
use eflima\core\models\Administrator;

/**
 * @author Rifan Firdhaus Widigdo <rifanfirdhaus@gmail.com>
 *
 * This is the ActiveQuery class for [[\eflima\core\models\Administrator]].
 *
 * @see    \eflima\core\models\Administrator
 */
class AdministratorQuery extends ActiveQuery
{
    /**
     * @inheritDoc
     *
     * @return Administrator[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritDoc
     *
     * @return Administrator|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
