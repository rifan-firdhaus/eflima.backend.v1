<?php namespace eflima\core\controllers\admin;

// "Keep the essence of your code, code isn't just a code, it's an art." -- Rifan Firdhaus Widigdo
use eflima\core\rest\Controller;

/**
 * @author Rifan Firdhaus Widigdo <rifanfirdhaus@gmail.com>
 */
class AccountController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator']);
        unset($behaviors['rateLimiter']);

        return $behaviors;
    }

    public function actionIndex()
    {
        return [
            'a' => 'b',
        ];
    }
}
