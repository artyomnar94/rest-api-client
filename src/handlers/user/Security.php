<?php


namespace CoreApiClient\handlers\user;

use CoreApiClient\handlers\BaseHandler;
use yii\httpclient\Client;
use yii\base\Model;
use yii\web\UnprocessableEntityHttpException;

/**
 * Class Security
 * @package CoreApiClient\handlers\user
 */
class Security extends BaseHandler
{
	private const ENTITY = 'security';

	/**
	 * Security constructor.
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
	 * @throws UnprocessableEntityHttpException
	 * @return bool
	 */
	public function changeEmail(Model $model, string $authToken): bool
	{
		$this->handlePutRequest(self::ENTITY . '/email', $model, $this->getDefaultHeaders($authToken));
		return true;
	}

	/**
	 * @param Model $model
	 * @param string $authToken
	 * @throws UnprocessableEntityHttpException
	 * @return bool
	 */
	public function confirmEmail(Model $model, string $authToken): bool
	{
		$this->handlePutRequest(self::ENTITY . '/confirm-email', $model, $this->getDefaultHeaders($authToken));
		return true;
	}

	/**
	 * @param Model $model
	 * @param string $authToken
	 * @throws UnprocessableEntityHttpException
	 * @return bool
	 */
	public function changePassword(Model $model, string $authToken): bool
	{
		$this->handlePutRequest(self::ENTITY . '/password', $model, $this->getDefaultHeaders($authToken));
		return true;
	}

	/**
	 * @param string $authToken
	 * @param array $params
	 * @return bool
	 */
	public function resendEmailCode(string $authToken, array $params): bool
	{
		$this->handleGetRequest(self::ENTITY . '/resend-email-code', $this->getDefaultHeaders($authToken), $params);
		return true;
	}

}