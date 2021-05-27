<?php


namespace CoreApiClient\handlers;

use CoreApiClient\RequestHelper;
use yii\httpclient\Client;
use yii\base\Model;
use yii\web\UnprocessableEntityHttpException;

/**
 * Class Payment
 * @package CoreApiClient\handlers
 */
class Payment extends BaseHandler
{
	private const ENTITY = 'payment';

	/**
	 * Payment constructor.
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
	 * @return array
	 */
	public function check(Model $model, string $authToken): ?array
	{
		return $this->handlePostRequest(self::ENTITY . '/check', $model, RequestHelper::getDefaultHeaders($authToken));
	}

	/**
	 * @param Model $model
	 * @param string $authToken
	 * @throws UnprocessableEntityHttpException
	 * @return array
	 */
	public function payFromCard(Model $model, string $authToken): array
	{
		return $this->handlePostRequest(self::ENTITY . '/pay-from-card', $model, RequestHelper::getDefaultHeaders($authToken));
	}

	/**
	 * @param Model $model
	 * @param string $authToken
	 * @throws UnprocessableEntityHttpException
	 * @return array
	 */
	public function payFromWallet(Model $model, string $authToken): array
	{
		return $this->handlePostRequest(self::ENTITY . '/pay-from-wallet', $model, RequestHelper::getDefaultHeaders($authToken));
	}

	/**
	 * @param Model $model
	 * @param string $authToken
	 * @throws UnprocessableEntityHttpException
	 * @return array
	 */
	public function payFromMobile(Model $model, string $authToken): array
	{
		return $this->handlePostRequest(self::ENTITY . '/pay-from-mobile', $model, RequestHelper::getDefaultHeaders($authToken));
	}

	/**
	 * @param Model $model
	 * @param string $authToken
	 * @throws UnprocessableEntityHttpException
	 * @return array
	 */
	public function approvePayFromMobile(Model $model, string $authToken): array
	{
		return $this->handlePostRequest(self::ENTITY . '/approve-pay-from-mobile', $model, RequestHelper::getDefaultHeaders($authToken));
	}

	/**
	 * @param Model $model
	 * @param string $authToken
	 * @throws UnprocessableEntityHttpException
	 * @return array
	 */
	public function transferFromCard(Model $model, string $authToken): array
	{
		return $this->handlePostRequest(self::ENTITY . '/transfer-from-card', $model, RequestHelper::getDefaultHeaders($authToken));
	}

	/**
	 * @param Model $model
	 * @param string $authToken
	 * @throws UnprocessableEntityHttpException
	 * @return array
	 */
	public function transferToCard(Model $model, string $authToken): array
	{
		return $this->handlePostRequest(self::ENTITY . '/transfer-to-card', $model, RequestHelper::getDefaultHeaders($authToken));
	}

	/**
	 * @param Model $model
	 * @param string $authToken
	 * @return array
	 */
	public function debt(Model $model, string $authToken): array
	{
		return $this->handlePostRequest( self::ENTITY . '/debt', $model, RequestHelper::getDefaultHeaders($authToken));
	}

	/**
	 * @param Model $model
	 * @param string $authToken
	 * @return array
	 */
	public function nativeTransferFromCard(Model $model, string $authToken): array
	{
		return $this->handlePostRequest(self::ENTITY . '/native-transfer-from-card', $model, RequestHelper::getDefaultHeaders($authToken));
	}

	/**
	 * @param string $authToken
	 * @param array $params
	 * @return array
	 */
	public function transferToCardContinue(string $authToken, array $params = []): array
	{
		return $this->handleGetRequest(self::ENTITY . '/transfer-to-card-continue', RequestHelper::getDefaultHeaders($authToken), $params);
	}

	/**
	 * @param string $authToken
	 * @param array $params
	 * @return array
	 */
	public function transferToCardComplete(string $authToken, array $params = []): array
	{
		return $this->handleGetRequest(self::ENTITY . '/transfer-to-card-complete', RequestHelper::getDefaultHeaders($authToken), $params);
	}

	/**
	 * @param Model $model
	 * @param string $authToken
	 * @return array
	 */
	public function nativeTransferToCard(Model $model, string $authToken): array
	{
		return $this->handlePostRequest(self::ENTITY . '/native-transfer-to-card', $model, RequestHelper::getDefaultHeaders($authToken));
	}

	/**
	 * @param Model $model
	 * @param string $authToken
	 * @return array
	 */
	public function transferToKazpost(Model $model, string $authToken): array
	{
		return $this->handlePostRequest(self::ENTITY . '/transfer-to-kazpost', $model, RequestHelper::getDefaultHeaders($authToken));
	}

	/**
	 * @param Model $model
	 * @param string $authToken
	 * @throws UnprocessableEntityHttpException
	 * @return array
	 */
	public function createOperation(Model $model, string $authToken): array
	{
		return $this->handlePostRequest(self::ENTITY . '/create-operation', $model, RequestHelper::getDefaultHeaders($authToken));
	}
}