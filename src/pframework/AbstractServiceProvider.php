<?php


namespace pframework;


use Symfony\Component\DependencyInjection\ContainerBuilder;

abstract class AbstractServiceProvider implements ServiceProviderInterface
{
    /**
     * @var ContainerBuilder
     */
    protected $container;

    /**
     * @var Application
     */
    protected $app;

    public function setContainer(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    public function setApp(Application $app)
    {
        $this->app = $app;
    }
}