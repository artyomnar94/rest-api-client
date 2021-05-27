<?php


namespace CoreApiClient\handlers\user;

use CoreApiClient\handlers\BaseHandler;
use yii\httpclient\Client;
use yii\base\Model;
use yii\web\UnprocessableEntityHttpException;

/**
 * Class Registration
 * @package CoreApiClient\handlers\user
 */
class Registration extends BaseHandler
{
	private const ENTITY = 'registration';

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
	 * @return bool
	 */
	public function createAccount(Model $model): bool
	{
		$this->handlePostRequest(self::ENTITY . '/create-account', $model, $this->getDefaultHeaders());
		return true;
	}

	/**
	 * @param Model $model
	 * @throws UnprocessableEntityHttpException
	 * @return bool
	 */
	public function activateAccount(Model $model): bool
	{
		$this->handlePostRequest(self::ENTITY . '/activate-account', $model, $this->getDefaultHeaders());
		return true;
	}

	/**
	 * @param Model $model
	 * @throws UnprocessableEntityHttpException
	 * @return bool
	 */
	public function setPassword(Model $model): bool
	{
		$this->handlePostRequest(self::ENTITY . '/set-password', $model, $this->getDefaultHeaders());
		return true;
	}
}