<?php


namespace CoreApiClient\handlers\service;

use CoreApiClient\handlers\BaseHandler;
use CoreApiClient\RequestHelper;
use yii\httpclient\Client;
use yii\base\Model;

/**
 * Class Category
 * @package CoreApiClient\handlers\service
 */
class Category extends BaseHandler
{
	private const ENTITY = 'category';

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
	 * @throws \yii\web\NotFoundHttpException
	 * @return array
	 */
	public function getAll(array $params = []): array
	{
		return $this->handleGetRequest(self::ENTITY, $this->getDefaultHeaders(), $params);
	}

	/**
	 * @param string $categoryId
	 * @throws \yii\web\NotFoundHttpException
	 * @return array
	 */
	public function getOne(string $categoryId): array
	{
		return $this->handleGetRequest(self::ENTITY . "/$categoryId", $this->getDefaultHeaders());
	}

	/**
	 * @param array $params
	 * @throws \yii\web\NotFoundHttpException
	 * @return array
	 */
	public function search(array $params = []): array
	{
		return $this->handleGetRequest(self::ENTITY . '/search', RequestHelper::getDefaultHeaders(), $params);
	}
}