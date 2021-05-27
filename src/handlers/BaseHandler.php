<?php


namespace CoreApiClient\handlers;

use Yii;
use yii\httpclient\Client;
use yii\httpclient\Response;
use yii\base\Model;
use yii\web\UnprocessableEntityHttpException;
use yii\web\NotFoundHttpException;

/**
 * Class BaseHandler
 * @package CoreApi
 */
class BaseHandler
{
	/**
	 * @var Client
	 */
	protected $client;

	/**
	 * @var string
	 */
	protected $partnerName;

	/**
	 * BaseEntity constructor.
	 *
	 * @param Client $client
	 * @param string $partnerName
	 */
	public function __construct(Client $client, string $partnerName = '')
	{
		$this->client = $client;
		$this->partnerName = $partnerName;
	}

	/**
	 * Binds error message to model attribute
	 *
	 * @param array $errorList - array[] where each element has field (attribute name) as key and message as value
	 */
	protected function addModelError(array $errorList, Model $model): void
	{
		try {
			foreach ($errorList as $error) {
				if ($model->hasProperty($error['field'])) {
					$model->addError($error['field'], $error['message']);
				}
			}
		} catch (\Throwable $exception) {
			Yii::error('CoreApi: exception per binding model error - ' . $exception->getMessage());
		}
	}

	/**
	 * Makes POST http request and returns response data or model with binded errors on attributes
	 *
	 * @param string $method
	 * @param Model $model
	 * @param array $headers
	 * @return array
	 * @throws \yii\httpclient\Exception
	 */
	protected function handlePostRequest(string $method, Model $model, array $headers): array
	{
		$response = $this->client->post($method, $model->getAttributes(), $headers)->send();
		return $this->handleResponseBody($response, $model);
	}

	/**
	 * Makes GET http request and returns response data
	 *
	 * @param string $method
	 * @param array $headers
	 * @param array $params - GET parameters list
	 * @return array
	 * @throws \yii\httpclient\Exception
	 * @throws NotFoundHttpException
	 */
	protected function handleGetRequest(string $method, array $headers, array $params = []): array
	{
		$response = $this->client->get($method, $params, $headers)->send();
		if ($response->isOk) {
			return $response->data;
		}
		throw new NotFoundHttpException();
	}

	/**
	 * Makes PUT http request and returns response data or model with binded errors on attributes
	 *
	 * @param string $method
	 * @param Model $model
	 * @param array $headers
	 * @return array
	 * @throws \yii\httpclient\Exception
	 * @throws UnprocessableEntityHttpException
	 */
	protected function handlePutRequest(string $method, Model $model, array $headers): array
	{
		$response = $this->client->put($method, $model->getAttributes(), $headers)->send();
		return $this->handleResponseBody($response, $model);
	}

	/**
	 * @param Response $response
	 * @param Model $model
	 * @return array
	 */
	private function handleResponseBody(Response $response, Model $model): array
	{
		if ($response->isOk) {
			return empty($response->data) ? [] : $response->data;
		}
		$this->addModelError($response->data, $model);
		throw new UnprocessableEntityHttpException();
	}

	/**
	 * Returns http-headers list for request
	 *
	 * @param string $authToken - user auth token
	 * @return array
	 */
	public function getDefaultHeaders(string $authToken = ''): array
	{
		$defaultHeaders = [
			'ip-address' => Yii::$app->request->userIP,
			'language' => substr(Yii::$app->language, 0, 2)
		];
		if ($this->partnerName) {
			$defaultHeaders = array_merge($defaultHeaders, ['partner-name' => $this->partnerName]);
		}
		if ($authToken) {
			$defaultHeaders = array_merge($defaultHeaders, ['authorization' => $authToken]);
		}

		return $defaultHeaders;
	}

}