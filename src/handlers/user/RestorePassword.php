<?php


namespace CoreApiClient\handlers\user;

use CoreApiClient\handlers\BaseHandler;
use yii\httpclient\Client;
use yii\base\Model;

/**
 * Class RestorePassword
 * @package CoreApiClient\handlers\user
 */
class RestorePassword extends BaseHandler
{
	private const ENTITY = 'restore-password';

	/**
	 * RestorePassword constructor.
	 *
	 * @param Client $client
	 * @param string $partnerName
	 */
	public function __construct(Client $client, string $partnerName = '')
	{
		parent::__construct($client, $partnerName);
	}

	/**
	 * @param Model $model
	 * @param string $authToken
	 * @throws yii\web\UnprocessableEntityHttpException
	 * @return bool
	 */
	public function request(Model $model, string $authToken): bool
	{
		$this->handlePostRequest(self::ENTITY . '/request', $model, $this->getDefaultHeaders($authToken));
		return true;
	}

	/**
	 * @param Model $model
	 * @param string $authToken
	 * @throws yii\web\UnprocessableEntityHttpException
	 * @return bool
	 */
	public function checkCode(Model $model, string $authToken): bool
	{
		$this->handlePostRequest(self::ENTITY . '/check-code', $model, $this->getDefaultHeaders($authToken));
		return true;
	}

	/**
	 * @param Model $model
	 * @param string $authToken
	 * @throws yii\web\UnprocessableEntityHttpException
	 * @return bool
	 */
	public function confirm(Model $model, string $authToken): bool
	{
		$this->handlePostRequest(self::ENTITY . '/confirm', $model, $this->getDefaultHeaders($authToken));
		return true;
	}
}