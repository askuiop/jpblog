<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 16-9-12
 * Time: 下午1:04
 */

namespace BlogBundle\Exception;


use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AccessDeniedWithRouteException extends AccessDeniedException
{
	/**
	 * @var string
	 */
	private $traceRoute;

	/**
	 * AccessDeniedWithUrlException constructor.
	 */
	public function __construct($message = 'Access Denied.', \Exception $previous = null, $traceRoute = '')
	{
		if (empty($message)) {
			$message = 'Access Denied.';
		}
		parent::__construct($message, $previous);

		$this->traceRoute = $traceRoute;
	}

	/**
	 * @return string
	 */
	public function getTraceRoute()
	{
		return $this->traceRoute;
	}

	/**
	 * @param string $traceRoute
	 */
	public function setTraceRoute($traceRoute)
	{
		$this->traceRoute = $traceRoute;
	}




}