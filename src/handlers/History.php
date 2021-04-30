<?php


namespace CoreApiClient\handlers;

use yii\httpclient\Client;
use yii\base\Model;

/**
 * Class History
 * @package CoreApiClient\handlers
 */
class History extends BaseHandler
{
	private const ENTITY = 'history';

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
	 * @param array $params
	 * @return array|null
	 */
	public function getAll(string $authToken, array $params = [])
	{
		return $this->handleGetRequest(self::ENTITY, $this->getDefaultHeaders($authToken), $params);
	}

	/**
	 * @param string $authToken
	 * @param string $operationId
	 * @return array|null
	 */
	public function getOne(string $authToken, string $operationId)
	{
		return $this->handleGetRequest(self::ENTITY . "/$operationId", $this->getDefaultHeaders($authToken));
	}

	/**
	 * Returns receipt raw data
	 *
	 * @param string $authToken
	 * @param string $operationId
	 * @return array|null
	 */
	public function getReceipt(string $authToken, string $operationId): ?array
	{
		return $this->handleGetRequest(self::ENTITY . "/receipt/$operationId", $this->getDefaultHeaders($authToken));
	}

	/**
	 * Returns receipt file in PDF by default or in HTML format
	 *
	 * @param string $authToken
	 * @param string $operationId
	 * @param bool $renderHtml - whether render HTML file
	 * @throws yii\web\UnprocessableEntityHttpException
	 * @return string
	 */
	public function getReceiptFile(string $authToken, string $operationId, bool $renderHtml = false): string
	{
		$method = $renderHtml ? self::ENTITY . "/receipt/pdf/$operationId/render=true" : self::ENTITY . "/receipt/pdf/$operationId";
		$response = $this->client->get($method, null, $this->getDefaultHeaders($authToken))->send();
		if ($response->isOk) {
			return $response->data;
		}
		throw new yii\web\UnprocessableEntityHttpException();
	}

}