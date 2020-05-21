<?php namespace eflima\core\controllers\admin;

// "Keep the essence of your code, code isn't just a code, it's an art." -- Rifan Firdhaus Widigdo
use eflima\core\Core;
use eflima\core\rest\Controller;
use Yii;

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

    public function actionLogin()
    {

    }

    public function actionIndex()
    {
        //        $account = new Account([
        //            'email' => 'rifanfirdhaus@gmail.com',
        //            'username' => 'rifan',
        //            'password' => 'rifan1234'
        //        ]);
        //
        //        $account->save(false);

        /** @var Core $core */
        $core = Yii::$app->getModule('core');

        $response = $core->oauth2->handleTokenRequest();

        return $response->parameters;
    }
}
