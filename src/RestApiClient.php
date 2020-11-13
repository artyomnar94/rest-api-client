<?php

namespace restApiClient\src;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;
use yii\httpclient\Exception;
use yii\httpclient\Response;

/**
 * Class RestApiClient - component - wrapper for working with Rest Api
 *
 * @property Client $client
 * @package restApiClient\src
 */
class RestApiClient extends Component
{
	private $client;

	/**
	 * There is an convention: root keys performed as entities, root values contains
	 * entitiy method name as key and remote API method name as a value.
	 * @var array $methodUrlList - contains url links by domain - model
	 */
	private static $methodUrlList = [
		self::DOMAIN_CORE => [
			'User' => [
				'create' => 'registration/create-account',
				'activate' => 'registration/activate-account',
				'set-password' => 'registration/set-password',
                'password-change-request' => 'restore-password/request',
                'set-new-password' => 'restore-password/check-code',
                'confirm-code' => 'restore-password/confirm',
				'auth' => 'auth',
				'pseudo' => 'auth/pseudo',
			],
			'Service' => [
				'get-categories' => 'service-category',
				'get-services' => 'service',
				'search' => 'service/search',
			],
			'Payment' => [
				'check' => 'payment/check',
				'card' => 'payment/pay-from-card',
				'create-operation' => 'payment/native/create-operation',
				'native-pay' => 'payment/native/pay-from-card',
				'debt' => 'payment/debt',
			],
			'History' => [
				'receipt' => 'history/receipt/'
			],
			'Card' => [
				'native-card-linking' => 'card/native-attach',
				'card-delete' => 'card/',
				'approve' => 'card/approve',
			]
		]
	];

	const METHOD_POST = 'post';
	const METHOD_GET = 'get';
	const METHOD_PUT = 'put';
	const METHOD_DELETE = 'delete';

	const DOMAIN_CORE = 'core';

	const URL_CORE = YII_ENV_PROD? 'https://api-core.wooppay.com/v1/' : 'https://api.yii2-stage.test.wooppay.com/v1/';

	/**
	 * Returns url list to work with api
	 *
	 * @param string $domain
	 * @return array
	 */
	public static function getMethodUrlList(string $domain = self::DOMAIN_CORE): array
	{
		return self::$methodUrlList[$domain];
	}

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
		$this->client = new Client();
	}

	/**
	 * Sends rest api request and handle response
	 *
	 * @param string $url
	 * @param array $body
	 * @param array $headers
	 * @param string $method
	 * @param string $format
	 * @param bool $coreUrl
	 * @return array - which contains status and response as {@see yii\httpclient\Response} if was successful request or as array error list if an exception
	 */
	public function send(string $url, array $body = [], array $headers = [], string $method = self::METHOD_POST, string $format = Client::FORMAT_JSON, bool $coreUrl = true) : array
	{
		try {
			/**
			 * @var Response $response
			 */
			$response = $this->client->createRequest()
				->setFormat($format)
				->setMethod($method)
				->setUrl($coreUrl ? self::URL_CORE.$url : (string)$url)
				->setHeaders($this->formatHeaders($headers))
				->setData($body)
				->send();

			$data = [];
			$this->getDataFromResponse($response, $data);
		} catch (InvalidConfigException $e) {
			$response = $e->getMessage();
		} catch (Exception $e) {
			$response = $e->getMessage();
		}
		return $data?? ['success' => false, 'response' => $response];
	}

	/**
	 * Checks response status and returns array - which contains status and response as {@see yii\httpclient\Response}
	 * if was success or as array error list if an exception
	 *
	 * @param Response $response
	 * @param array $data
	 */
	private function getDataFromResponse(Response $response, array &$data)
	{
		try {
			$statusCode = $response->getStatusCode();
		} catch (Exception $e) {
			$statusCode = HttpResponseStatusEnum::INTERNAL_SERVER_ERROR;
		}
		if (in_array($statusCode, HttpResponseStatusEnum::getSuccessStatusList())) {
			$data['success'] = true;
			$data['response'] = $response;
		} else {
			$data['success'] = false;
			$data['response'] = $this->getErrorMessages($statusCode, $response->getData());
		}
	}

	/**
	 * Returns list of errors per unsuccessful request
	 *
	 * @param string $statusCode - server response status value
	 * @param $responseData - server response body
	 * @return array
	 */
	private function getErrorMessages(string $statusCode, $responseData) : array
	{
		if (in_array($statusCode, HttpResponseStatusEnum::getClientErrorStatusList())) {
			return $this->formatMessageList($responseData);
		} elseif (in_array($statusCode, HttpResponseStatusEnum::getServerErrorStatusList())) {
			return $responseData;
		}
	}

	/**
	 * Modifying error displaying: attribute as key and message as value
	 *
	 * @param array $messages
	 * @return array
	 */
	private function formatMessageList(array $messages) : array
	{
		$formattedMessageList = [];
		foreach ($messages as $key => $value) {
			if (!is_array($value)) {
				$formattedMessageList[$key] = $value;
			} else {
				$values = array_values($value);
				$formattedMessageList[$values[0]] = $values[1];
			}
		}

		return $formattedMessageList;
	}

	/**
	 * Formats headers to low register
	 *
	 * @param array $headers
	 * @return array
	 */
	private function formatHeaders(array $headers): array
	{
		$headers = array_merge($headers, [
			'language' => Yii::$app->language,
			'ip-address' => Yii::$app->request->userIP,
			'partner-name' => Yii::$app->params['partner_name']
		]);
		if ($headers) {
			$formattedHeaders = [];
			foreach ($headers as $key => $value) {
				$formattedHeaders[strtolower($key)] = $value;
			}
		}
		return $formattedHeaders ?? [];
	}
}
