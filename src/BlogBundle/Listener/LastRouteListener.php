<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 16-8-2
 * Time: 下午1:22
 */

namespace BlogBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;


class LastRouteListener
{
	public function onKernelRequest(GetResponseEvent $event)
	{
		// Do not save subrequests
		if ($event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
			return;
		}

		$request = $event->getRequest();
		$session = $request->getSession();

		$routeName = $request->get('_route');
		$routerParams = $request->get('_route_params');

		if ($routeName[0] == '_') {
			return;
		}
		$routeData = ['route' => $routeName, 'params' => $routerParams ];

		$current_route = $session->get('current_route', []);

		if ( $current_route == $routeData ) {
			return;
		}

		$session->set('current_route', $routeData);
		$session->set('last_route', $current_route);

	}

}