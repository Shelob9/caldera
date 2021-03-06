<?php


namespace calderawp\caldera\restApi;

use calderawp\caldera\restApi\Contracts\RouteContract;
use calderawp\interop\Traits\Rest\ProvidesRoute;
use calderawp\interop\Contracts\WordPress\ApplysFilters;
use calderawp\interop\Exception;
use calderawp\interop\Contracts\Rest\RestResponseContract;

abstract class Route implements RouteContract
{
	use ProvidesRoute;

	/**
	 * @var CalderaRestApi
	 */
	protected $module;

	/**
	 * Route constructor.
	 *
	 * @param CalderaRestApi $module
	 */
	public function __construct(CalderaRestApi$module)
	{
		$this->module = $module;
	}

	/** @inheritdoc */
	public function getFilters(): ApplysFilters
	{
		return $this
			->module
			->getCalderaEvents()
			->getHooks();
	}

	protected function exceptionToResponse(Exception $exception) : RestResponseContract
	{
		return (new Response() )->setStatus($exception->getCode())->setData(['message' => $exception->getMessage()]);
	}
}
