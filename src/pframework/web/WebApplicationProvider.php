<?php


namespace pframework\web;


use pframework\AbstractServiceProvider;
use pframework\Event;
use pframework\web\middleware\RouteMiddleware;
use Symfony\Component\EventDispatcher\GenericEvent;

class WebApplicationProvider extends AbstractServiceProvider
{
    public function boot()
    {
        $webApp = new WebApplication();

        // 注册中间件
        $webApp->addMiddleware(RouteMiddleware::class);

        // 注册路由
        $config = $this->app->getConfig();
        $webApp->addRoute($config['route']);

        $this->container->set(WebApplicationInterface::class, $webApp);

        $this->app->getEventDispatcher()->addListener(Event::REQUEST, function (GenericEvent $event) use ($webApp) {
            $response = $webApp->run();
            $event->getSubject()->end($response->getContent());
        });
    }
}