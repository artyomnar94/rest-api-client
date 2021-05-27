<?php


namespace CoreApiClient\handlers\user;

use CoreApiClient\handlers\BaseHandler;
use yii\httpclient\Client;
use yii\base\Model;
use yii\web\UnprocessableEntityHttpException;

/**
 * Class User
 * @package CoreApiClient\handlers\user
 */
class User extends BaseHandler
{
	/**
	 * @var Registration
	 */
	private $registration;

	/**
	 * @var RestorePassword
	 */
	private $restorePassword;

	/**
	 * @var Auth
	 */
	private $auth;

	/**
	 * @var Security
	 */
	private $security;

	/**
	 * @var Profile
	 */
	private $profile;

	/**
	 * User constructor.
	 *
	 * @param Client $client
	 * @param string $partnerName
	 */
	public function __construct(Client $client, string $partnerName = '')
	{
		parent::__construct($client, $partnerName);
		$this->registration = new Registration($client, $partnerName);
		$this->restorePassword = new RestorePassword($client, $partnerName);
		$this->auth = new Auth($client, $partnerName);
		$this->security = new Security($client, $partnerName);
		$this->profile = new Profile($client, $partnerName);
	}

	/**
	 * @param Model $model
	 * @return bool
	 */
	public function createAccount(Model $model): bool
	{
		return $this->registration->createAccount($model);
	}

	/**
	 * @param Model $model
	 * @return bool
	 */
	public function activateAccount(Model $model): bool
	{
		return $this->registration->activateAccount($model);
	}

	/**
	 * @param Model $model
	 * @return bool
	 */
	public function setPassword(Model $model): bool
	{
		return $this->registration->setPassword($model);
	}

	/**
	 * @param Model $model
	 * @return bool
	 */
	public function restorePasswordRequest(Model $model): bool
	{
		return $this->restorePassword->request($model);
	}

	/**
	 * @param Model $model
	 * @return bool
	 */
	public function passwordCheckCode(Model $model): bool
	{
		return $this->restorePassword->checkCode($model);
	}

	/**
	 * @param Model $model
	 * @return bool
	 */
	public function passwordConfirm(Model $model): bool
	{
		return $this->restorePassword->confirm($model);
	}

	/**
	 * @param Model $model
	 * @return array
	 */
	public function auth(Model $model): array
	{
		return $this->auth->auth($model);
	}

	/**
	 * @param Model $model
	 * @return array
	 */
	public function authPseudo(Model $model): array
	{
		return $this->auth->pseudo($this->model);
	}

	/**
	 * @param string $authToken
	 * @return array
	 */
	public function getIdentity(string $authToken): array
	{
		return $this->auth->getIdentity($authToken);
	}

	/**
	 * @param string $login
	 * @param string $authToken
	 * @throws UnprocessableEntityHttpException
	 * @return array
	 */
	public function nominateSubject(string $login, string $authToken): array
	{
		$response = $this->client->post('user/nominate-subject', ['phone' => $login], $this->getDefaultHeaders($authToken))->send();
		if ($response->isOk) {
			return $response->data;
		}
		throw new UnprocessableEntityHttpException();
	}

	/**
	 * @param string $authToken
	 * @return array
	 */
	public function idStatus(string $authToken): array
	{
		return $this->handleGetRequest('user/id-status', $this->getDefaultHeaders($authToken));
	}

	/**
	 * @param Model $model
	 * @param string $authToken
	 * @return bool
	 */
	public function changeEmail(Model $model, string $authToken): bool
	{
		return $this->security->changeEmail($model, $authToken);
	}

	/**
	 * @param Model $model
	 * @param string $authToken
	 * @return bool
	 */
	public function changePassword(Model $model, string $authToken): bool
	{
		return $this->security->changePassword($model, $authToken);
	}

	/**
	 * @param Model $model
	 * @param string $authToken
	 * @return bool
	 */
	public function confirmEmail(Model $model, string $authToken): bool
	{
		return $this->security->confirmEmail($model, $authToken);
	}

	/**
	 * @param string $authToken
	 * @param array $params
	 * @return bool
	 */
	public function resendEmailCode(string $authToken, array $params): bool
	{
		return $this->security->resendEmailCode($authToken, $params);
	}

	/**
	 * @param string $authToken
	 * @return array
	 */
	public function getProfileData(string $authToken): array
	{
		return $this->profile->getProfileData($authToken);
	}
}