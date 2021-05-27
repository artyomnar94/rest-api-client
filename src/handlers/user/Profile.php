<?php


namespace CoreApiClient\handlers\user;


use CoreApiClient\handlers\BaseHandler;
use yii\httpclient\Client;

/**
 * Class Profile
 * @package CoreApiClient\handlers\user
 */
class Profile extends BaseHandler
{
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
	 * @return array
	 */
	public function getProfileData(string $authToken): array
	{
		return $this->handleGetRequest('profile', $this->getDefaultHeaders($authToken));
	}
}