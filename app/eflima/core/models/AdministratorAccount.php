<?php namespace eflima\core\models;

// "Keep the essence of your code, code isn't just a code, it's an art." -- Rifan Firdhaus Widigdo

/**
 * @author Rifan Firdhaus Widigdo <rifanfirdhaus@gmail.com>
 */
class AdministratorAccount extends Account
{
    public function normalizeAttributes($save)
    {
        if ($save) {
            $this->type = 'administrator';
        }

        parent::normalizeAttributes($save);
    }
}
