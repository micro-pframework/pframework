<?php

namespace pframework\web;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WebApplication implements WebApplicationInterface
{
    private $route = [];
    private $middleware = [];

    public function addRoute($route)
    {
        $this->route = $route;
    }

    public function addMiddleware($middlewareClass)
    {
        $this->middleware[] = $middlewareClass;
    }

    public function run()
    {
        // 创建request对象
        $request = Request::createFromGlobals();
        $response = new Response();

        // 调用中间件处理请求
        $this->callMiddleware($request, $response);

        // 返回响应
        return $response;
    }

    protected function callMiddleware($request, $response, $index = 0)
    {
        if (!isset($this->middleware[$index])) {
            return $response;
        }

        $middleware = new $this->middleware[$index];
        return $middleware($request, $response, function ($request, $response) use ($index) {
            $this->callMiddleware($request, $response, $index + 1);
        });
    }

}