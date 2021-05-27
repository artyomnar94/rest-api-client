<?php


namespace CoreApiClient\handlers\user;

use CoreApiClient\handlers\BaseHandler;
use yii\httpclient\Client;
use yii\base\Model;
use yii\web\UnprocessableEntityHttpException;

/**
 * Class Auth
 * @package CoreApiClient\handlers\user
 */
class Auth extends BaseHandler
{
	private const ENTITY = 'auth';

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
	 * @param Model $model
	 * @throws UnprocessableEntityHttpException
	 * @return array
	 */
	public function auth(Model $model): array
	{
		return $this->handlePostRequest(self::ENTITY, $model, $this->getDefaultHeaders());
	}

	/**
	 * @param string $authToken
	 * @throws UnprocessableEntityHttpException
	 * @return array
	 */
	public function getIdentity(string $authToken): array
	{
		return $this->handleGetRequest(self::ENTITY, $this->getDefaultHeaders($authToken));
	}

	/**
	 * @param Model $model
	 * @throws UnprocessableEntityHttpExceptionl
	 * @return array|null
	 */
	public function pseudo(Model $model): array
	{
		return $this->handlePostRequest(self::ENTITY . '/pseudo', $model, $this->getDefaultHeaders());
	}

}