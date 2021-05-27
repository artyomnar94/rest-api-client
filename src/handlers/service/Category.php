<?php


namespace CoreApiClient\handlers\service;

use CoreApiClient\handlers\BaseHandler;
use yii\httpclient\Client;
use yii\base\Model;
use yii\web\NotFoundHttpException;

/**
 * Class Category
 * @package CoreApiClient\handlers\service
 */
class Category extends BaseHandler
{
	private const ENTITY = 'service-category';

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
	 * @param string $categoryId
	 * @throws NotFoundHttpException
	 * @return array
	 */
	public function getOne(string $categoryId): array
	{
		return $this->handleGetRequest(self::ENTITY . "/$categoryId", $this->getDefaultHeaders());
	}

	/**
	 * @param array $params
	 * @throws NotFoundHttpException
	 * @return array
	 */
	public function search(array $params = []): array
	{
		return $this->handleGetRequest(self::ENTITY . '/search', $this->getDefaultHeaders(), $params);
	}
}