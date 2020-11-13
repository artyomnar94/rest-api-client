<?php

namespace restApiClient\src;

/**
 * Class HttpResponseStatusEnum
 * For more http status info {@see http://www.restapitutorial.ru/httpstatuscodes.html}
 *
 * @package restApiClient\src
 */
class HttpResponseStatusEnum extends BaseEnum
{
	/**
	 * Success statuses 2xx
	 */
	const OK = 200;
	const CREATED = 201;
	const ACCEPTED = 202;
	const NO_CONTENT = 204;
	const RESET_CONTENT = 205;

	/**
	 * Redirect statuses 3xx
	 */
	const NOT_MODIFIED = 304;

	/**
	 * Client errors 4xx
	 */
	const BAD_REQUEST = 400;
	const UNAUTHORIZED = 401;
	const FORBIDDEN = 403;
	const NOT_FOUND = 404;
	const METHOD_NOT_ALLOWED = 405;
	const UNPROCESSABLE_ENTITY = 422;

	/**
	 * Server errors 5xx
	 */
	const INTERNAL_SERVER_ERROR = 500;

	/**
	 * Returns successful status list including status = 304 (cache available)
	 * @return array
	 */
	public static function getSuccessStatusList() : array
	{
		return [
			self::OK,
			self::CREATED,
			self::ACCEPTED,
			self::NOT_MODIFIED,
			self::NO_CONTENT,
			self::RESET_CONTENT,
		];
	}

	/**
	 * Returns client-side error status list
	 * @return array
	 */
	public static function getClientErrorStatusList() : array
	{
		return [
			self::BAD_REQUEST,
			self::UNAUTHORIZED,
			self::FORBIDDEN,
			self::NOT_FOUND,
			self::METHOD_NOT_ALLOWED,
			self::UNPROCESSABLE_ENTITY,
		];
	}

	/**
	 * Returns server-side error status list
	 * @return array
	 */
	public static function getServerErrorStatusList() : array
	{
		return [
			self::INTERNAL_SERVER_ERROR,
		];
	}
