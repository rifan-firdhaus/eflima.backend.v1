<?php namespace eflima\core\components\oauth2;

// "Keep the essence of your code, code isn't just a code, it's an art." -- Rifan Firdhaus Widigdo
use OAuth2\ResponseInterface;
use Yii;
use yii\base\BaseObject;

/**
 * @author Rifan Firdhaus Widigdo <rifanfirdhaus@gmail.com>
 *
 * @property string|int $statusCode
 */
class Response extends BaseObject implements ResponseInterface
{
    public $parameters = [];

    /**
     * @inheritDoc
     */
    public function addParameters(array $parameters)
    {
        $this->parameters = array_merge($parameters,$this->parameters);
    }

    /**
     * @inheritDoc
     */
    public function addHttpHeaders(array $httpHeaders)
    {
        foreach ($httpHeaders as $name => $value) {
            Yii::$app->response->headers->set($name, $value);
        }
    }

    /**
     * @inheritDoc
     */
    public function setStatusCode($statusCode)
    {
        Yii::$app->response->setStatusCode($statusCode);
    }

    /**
     * @inheritDoc
     */
    public function setError($statusCode, $name, $description = null, $uri = null)
    {
        Yii::$app->response->setStatusCode($statusCode, $description);
    }

    /**
     * @inheritDoc
     */
    public function setRedirect($statusCode, $url, $state = null, $error = null, $errorDescription = null, $errorUri = null)
    {
        Yii::$app->response->redirect($url, $statusCode);
    }

    /**
     * @inheritDoc
     */
    public function getParameter($name)
    {
        return isset($this->parameters[$name]) ? $this->parameters[$name] : null;
    }
}
