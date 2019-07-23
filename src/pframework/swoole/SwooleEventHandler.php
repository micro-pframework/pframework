<?php

namespace pframework\swoole;

use pframework\Application;
use pframework\Event;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\GenericEvent;

class SwooleEventHandler
{
    private $container;

    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    public function onStart()
    {
        Application::getInstance()->getEventDispatcher()->dispatch(Event::START, new GenericEvent());
    }

    public function onRequest(Request $request, Response $response)
    {
        $server = array_change_key_case($request->server, CASE_UPPER);
        foreach ($request->header as $key => $val) {
            $server['HTTP_' . str_replace('-', '_', strtoupper($key))] = $val;
        }
        $_SERVER = $server;

        Application::getInstance()->getEventDispatcher()->dispatch(Event::REQUEST, new GenericEvent($response));
    }
}