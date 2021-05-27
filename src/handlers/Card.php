<?php


namespace CoreApiClient\handlers;

use yii\httpclient\Client;
use yii\base\Model;
use yii\web\UnprocessableEntityHttpException;

/**
 * Class Card
 * @package CoreApiClient\handlers\user
 */
class Card extends BaseHandler
{
	private const ENTITY = 'card';

	/**
	 * Auth constructor.
	 *
	 * @param Client $client
	 * @param string $partnerName
	 */
	public function __construct(Client $client, string $partnerName = '')
	{
		parent::__construct($client, $partnerName);
	}

	/**
	 * @param string $authToken
	 * @throws UnprocessableEntityHttpException
	 * @return array
	 */
	public function getAll(string $authToken): array
	{
		return $this->handleGetRequest(self::ENTITY, $this->getDefaultHeaders($authToken));
	}

	/**
	 * @param string $authToken
	 * @param string $cardId
	 * @throws UnprocessableEntityHttpException
	 * @return array
	 */
	public function getOne(string $authToken, string $cardId): array
	{
		return $this->handleGetRequest(self::ENTITY . "/$cardId", $this->getDefaultHeaders($authToken));
	}

	/**
	 * @param string $authToken
	 * @param string $cardId
	 * @return bool
	 */
	public function delete(string $authToken, string $cardId): bool
	{
		$response = $this->client->delete(self::ENTITY . "/$cardId", null, $this->getDefaultHeaders($authToken));
		return $response->isOk;
	}

	/**
	 * @param string $authToken
	 * @param array $params
	 * @return array|null
	 */
	public function attach(string $authToken, array $params = []): ?array
	{
		return $this->handleGetRequest(self::ENTITY . '/attach', $this->getDefaultHeaders($authToken), $params);
	}

	/**
	 * @param Model $model
	 * @param string $authToken
	 * @param array $params
	 * @throws UnprocessableEntityHttpException
	 * @return array
	 */
	public function approve(Model $model, string $authToken, array $params = []): array
	{
		$response = $this->client->put(self::ENTITY . '/approve', $params, $this->getDefaultHeaders($authToken));
		if ($response->isOk) {
			return $response->data;
		}
		throw new UnprocessableEntityHttpException();
	}

	/**
	 * @param string $authToken
	 * @param array $params
	 * @return array
	 */
	public function nativeAttach(string $authToken, array $params = []): array
	{
		return $this->handleGetRequest(self::ENTITY . '/native-attach', $this->getDefaultHeaders($authToken), $params);
	}

	/**
	 * @param string $authToken
	 * @param array $params
	 * @throws UnprocessableEntityHttpException
	 * @return string
	 */
	public function nativeWrapper(string $authToken, array $params = []): string
	{
		$response = $this->client->get(self::ENTITY . '/native-wrapper', $params, $this->getDefaultHeaders($authToken))->send();
		if ($response->isOk) {
			return $response->data;
		}
		throw new UnprocessableEntityHttpException();
	}

	/**
	 * @param Model $model
	 * @param string $authToken
	 * @throws UnprocessableEntityHttpException
	 * @return array|null
	 */
	public function sendAuthCode(Model $model, string $authToken): ?array
	{
		return $this->handlePostRequest(self::ENTITY . '/send-auth-code', $model, $this->getDefaultHeaders($authToken));
	}
}