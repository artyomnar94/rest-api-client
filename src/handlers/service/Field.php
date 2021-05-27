<?php


namespace CoreApiClient\handlers\service;

use CoreApiClient\handlers\BaseHandler;
use yii\httpclient\Client;
use yii\base\Model;
use yii\web\NotFoundHttpException;

/**
 * Class Field
 * @package CoreApiClient\handlers\service
 */
class Field extends BaseHandler
{
	private const ENTITY = 'service-field';

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
	 * @param array $params
	 * @throws NotFoundHttpException
	 * @return array
	 */
	public function getAll(array $params = []): array
	{
		return $this->handleGetRequest(self::ENTITY, $this->getDefaultHeaders(), $params);
	}

	/**
	 * @param string $fieldId
	 * @throws NotFoundHttpException
	 * @return array
	 */
	public function getOne(string $fieldId): array
	{
		return $this->handleGetRequest(self::ENTITY . "/$fieldId", $this->getDefaultHeaders());
	}
}