<?php

namespace CoreApiClient;

use CoreApiClient\handlers\Card;
use CoreApiClient\handlers\History;
use CoreApiClient\handlers\Payment;
use CoreApiClient\handlers\service\Service;
use CoreApiClient\handlers\user\User;
use Yii;
use yii\base\Component;
use yii\httpclient\Client;

/**
 * Class CoreApi - the Core's main interface
 *
 * @package Yii2CoreClient
 */
class CoreApi extends Component
{
	/**
	 * @var string - provided from config
	 */
	public $coreHostName;

	/**
	 * @var string - provided from config
	 */
	public $partnerName = '';

	/**
	 * @property-read User $user Handler for request to user entity. This property is read-only.
	 */
	public $user;

	/**
	 * @property-read Service $service Handler for request to service entity. This property is read-only.
	 */
	public $service;

	/**
	 * @property-read Payment $payment Handler for request to payment entity. This property is read-only.
	 */
	public $payment;

	/**
	 * @property-read History $history Handler for request to operation history entity. This property is read-only.
	 */
	public $history;

	/**
	 * @property-read Card $card Handler for request to bank card entity. This property is read-only.
	 */
	public $card;

	/**
	 * @property-read Client $client Http-client (CURL wrapper)
	 */
	private $client;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
		$this->client = new Client(['baseUrl' => $this->coreHostName]);
		$this->user = new User($this->client, $this->partnerName);
		$this->service = new Service($this->client, $this->partnerName);
		$this->payment = new Payment($this->client, $this->partnerName);
		$this->history = new History($this->client, $this->partnerName);
		$this->card = new Card($this->client, $this->partnerName);
	}

}
