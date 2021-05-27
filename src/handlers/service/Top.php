<?php


namespace CoreApiClient\handlers\service;

use CoreApiClient\handlers\BaseHandler;
use yii\httpclient\Client;
use yii\base\Model;

/**
 * Class Top
 * @package CoreApiClient\handlers\service
 */
class Top extends BaseHandler
{
	private const ENTITY = 'service-top';

	/**
	 * Category constructor.
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
	 * @param array $params
	 * @return array
	 */
	public function getAll(string $authToken, array $params = []): array
	{
		return $this->handleGetRequest(self::ENTITY, $this->getDefaultHeaders($authToken), $params);
	}

	/**
	 * @param string $serviceId
	 * @param string $authToken
	 * @return array
	 */
	public function getOne(string $serviceId, string $authToken): array
	{
		return $this->handleGetRequest(self::ENTITY . "/$serviceId", $this->getDefaultHeaders($authToken));
	}

	/**
	 * @param string $serviceId
	 * @param string $authToken
	 * @return bool
	 */
	public function add(string $serviceId, string $authToken): bool
	{
		$response = $this->client->post(self::ENTITY . "/$serviceId", ['id' => $serviceId], $this->getDefaultHeaders($authToken))->send();
		return $response->isOk;
	}

	/**
	 * @param string $serviceId
	 * @param string $authToken
	 * @return bool
	 */
	public function edit(string $serviceId, string $authToken): bool
	{
		$response = $this->client->put(self::ENTITY . "/$serviceId", ['id' => $serviceId], $this->getDefaultHeaders($authToken))->send();
		return $response->isOk;
	}

	/**
	 * @param string $serviceId
	 * @param string $authToken
	 * @return bool
	 */
	public function delete(string $serviceId, string $authToken): bool
	{
		$response = $this->client->delete(self::ENTITY . "/$serviceId", ['id' => $serviceId], $this->getDefaultHeaders($authToken))->send();
		return $response->isOk;
	}
}