<?php


namespace CoreApiClient;

use Yii;

/**
 * Class RequestHelper
 * @package CoreApi
 */
class RequestHelper
{
	/**
	 * Request Header name for auth token providing
	 */
	const AUTHORIZATION = 'authorization';

	/**
	 * @param string $partnerName
	 * @return array
	 */
	public static function getDefaultHeaders(string $partnerName = ''): array
	{
		$defaultHeaders = [
			'ip-address' => Yii::$app->request->userIP,
			'language' => Yii::$app->language
		];
		if ($partnerName) {
			$defaultHeaders = array_merge($defaultHeaders, ['partner-name' => $partnerName]);
		}

		return $defaultHeaders;
	}

}