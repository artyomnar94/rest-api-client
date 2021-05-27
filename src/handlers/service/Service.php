<?php


namespace CoreApiClient\handlers\service;

use CoreApiClient\handlers\BaseHandler;
use CoreApiClient\RequestHelper;
use yii\httpclient\Client;
use yii\base\Model;
use yii\web\UnprocessableEntityHttpException;
use yii\web\NotFoundHttpException;

/**
 * Class Service
 * @package CoreApi\handlers
 */
class Service extends BaseHandler
{
	/**
	 * @var Category
	 */
	public $category;

	/**
	 * @var Field
	 */
	public $field;

	/**
	 * @var Top
	 */
	public $top;

	private const ENTITY = 'service';

	/**
	 * Auth constructor.
	 *
	 * @param Client $client
	 * @param string $partnerName
	 */
	public function __construct(Client $client, string $partnerName = '')
	{
		parent::__construct($client, $partnerName);
		$this->category = new Category($client, $partnerName);
		$this->field = new Field($client, $partnerName);
		$this->top = new Top($client, $partnerName);
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
	 * @param string $serviceAttribute - service id or name
	 * @throws NotFoundHttpException
	 * @return array
	 */
	public function getOne(string $serviceAttribute): array
	{
		return $this->handleGetRequest(self::ENTITY . "/$serviceAttribute", $this->getDefaultHeaders());
	}

	/**
	 * @param array $params
	 * @throws NotFoundHttpException
	 * @return array
	 */
	public function search(array $params = []): array
	{
		return $this->handleGetRequest(self::ENTITY . '/search', RequestHelper::getDefaultHeaders(), $params);
	}

	/**
	 * @param string $authToken
	 * @param string $serviceAttribute
	 * @param float $amount
	 * @throws UnprocessableEntityHttpException
	 * @return array|null
	 */
	public function commission(string $authToken, string $serviceAttribute, float $amount)
	{
		$headers = RequestHelper::getDefaultHeaders($authToken);
		$response = $this->client->post(self::ENTITY . "/commission/$serviceAttribute", ['amount' => $amount], $headers)->send();
		if ($response->isOk) {
			return $response->data;
		}
		throw new UnprocessableEntityHttpException();
	}

	/**
	 * @param array $params
	 * @throws NotFoundHttpException
	 * @return array
	 */
	public function getCategoryList(array $params = []): array
	{
		return $this->category->getAll($params);
	}

	/**
	 * @param string $categoryId
	 * @throws NotFoundHttpException
	 * @return array
	 */
	public function getCategory(string $categoryId)
	{
		return $this->category->getOne($categoryId);
	}

	/**
	 * @param array $params
	 * @throws NotFoundHttpException
	 * @return array
	 */
	public function findCategory(array $params = [])
	{
		return $this->category->search($params);
	}

	/**
	 * @param array $params
	 * @throws NotFoundHttpException
	 * @return array
	 */
	public function getFieldList(array $params)
	{
		return $this->field->getAll($params);
	}

	/**
	 * @param string $fieldId
	 * @throws NotFoundHttpException
	 * @return array
	 */
	public function getField(string $fieldId)
	{
		return $this->field->getOne($fieldId);
	}

	/**
	 * @param string $authToken
	 * @param array $params
	 * @throws NotFoundHttpException
	 * @return array
	 */
	public function getTopList(string $authToken, array $params = [])
	{
		return $this->top->getAll($authToken, $params);
	}

	/**
	 * @param string $serviceId
	 * @param string $authToken
	 * @throws NotFoundHttpException
	 * @return array
	 */
	public function getTopById(string $serviceId, string $authToken): array
	{
		return $this->top->getOne($serviceId, $authToken);
	}

	/**
	 * @param string $serviceId
	 * @param string $authToken
	 * @throws NotFoundHttpException
	 * @return bool
	 */
	public function newTop(string $serviceId, string $authToken): bool
	{
		return $this->top->add($serviceId, $authToken);
	}

	/**
	 * @param string $serviceId
	 * @param string $authToken
	 * @throws NotFoundHttpException
	 * @return bool
	 */
	public function editTop(string $serviceId, string $authToken): bool
	{
		return $this->top->edit($serviceId, $authToken);
	}

	/**
	 * @param string $serviceId
	 * @param string $authToken
	 * @throws NotFoundHttpException
	 * @return bool
	 */
	public function deleteTop(string $serviceId, string $authToken): bool
	{
		return $this->top->delete($serviceId, $authToken);
	}
}