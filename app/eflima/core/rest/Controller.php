<?php namespace eflima\core\rest;

// "Keep the essence of your code, code isn't just a code, it's an art." -- Rifan Firdhaus Widigdo
use Yii;
use yii\base\Arrayable;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\helpers\ArrayHelper;
use yii\rest\Controller as YiiRestController;
use yii\rest\Serializer;

/**
 * @author Rifan Firdhaus Widigdo <rifanfirdhaus@gmail.com>
 */
class Controller extends YiiRestController
{
    /** @var Serializer */
    public $serializer = Serializer::class;

    public $messages = [];
    public $success = true;
    public $serializeResult = true;

    const MESSAGE_CATEGORY_NOTIFICATION = 'notification';
    const MESSAGE_CATEGORY_SUCCESS = 'success';
    const MESSAGE_CATEGORY_ERROR = 'error';
    const MESSAGE_CATEGORY_WARNING = 'warning';

    /**
     * @param null|string $message
     *
     * @return $this
     */
    public function success($message = null)
    {
        $this->success = true;

        if ($message !== null) {
            $this->addMessage(self::MESSAGE_CATEGORY_SUCCESS, $message);
        }

        return $this;
    }

    /**
     * @param null|string $message
     *
     * @return $this
     */
    public function failed($message = null)
    {
        $this->success = false;

        if ($message !== null) {
            $this->addMessage(self::MESSAGE_CATEGORY_ERROR, $message);
        }

        return $this;
    }

    /**
     * @param string $message
     * @param string $category
     *
     * @return $this
     */
    public function addMessage($message, $category = self::MESSAGE_CATEGORY_NOTIFICATION)
    {
        $this->messages[$category] = $message;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function serializeData($data)
    {
        if (!$this->serializeResult) {
            return $data;
        }

        $response = Yii::$app->getResponse();

        $data = [
            'success' => $this->success,
            'status' => [
                'code' => $response->getStatusCode(),
                'message' => $response->statusText,
            ],
            'messages' => $this->messages,
            'result' => parent::serializeData($data),
        ];

        if ($data instanceof Model && $data->hasErrors()) {
            $data['type'] = 'model-errors';
            $data['success'] = false;
        } elseif ($data instanceof Arrayable) {
            $data['type'] = $data instanceof Model ? 'model' : 'data';
        } elseif ($data instanceof DataProviderInterface) {
            $data['type'] = $data instanceof ActiveDataProvider ? 'model-list' : 'data-list';

            if (($pagination = $data->getPagination())) {
                $data['type'] = [
                    'total_count' => $pagination->totalCount,
                    'page_count' => $pagination->getPageCount(),
                    'current_page' => $pagination->getPage() + 1,
                    'page_size' => $pagination->pageSize,
                    'links' => $pagination->getLinks(true),
                ];
            }
        } else {
            $data['type'] = 'raw';

            if (ArrayHelper::isAssociative($data)) {
                $data['type'] = 'associative-array';
            } elseif (is_array($data)) {
                $data['type'] = 'array';
            }
        }

        return $data;
    }
}
