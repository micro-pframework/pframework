<?php

namespace pframework\web\middleware;

use pframework\Application;
use pframework\middleware\AbstractMiddleware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RouteMiddleware extends AbstractMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $uri = $request->getRequestUri();
        $routeList = $app = Application::getInstance()->getConfig()['route'];
        $controllerMethod = $routeList[$uri];

        list($controller, $method) = explode('::', $controllerMethod);
        $response->setContent(call_user_func_array([new $controller, $method], [$request, $response]));
        return $next($request, $response);
    }
}