<?php


namespace pframework;

use Exception;
use pframework\swoole\SwooleServerCommand;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * @author suxiaolin
 *
 * Class Application
 * @package pframework
 */
class Application
{
    private $configPath;
    private $config;
    private $container;
    private $eventDispatcher;

    private static $instance;

    public function __construct()
    {
        $this->container = new ContainerBuilder();
        $this->eventDispatcher = new EventDispatcher();

        $this->container->set(Application::class, $this);
        self::$instance = $this;
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function setConfigPath($configPath)
    {
        $this->configPath = $configPath;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function bootstrap()
    {
        $this->loadConfig();
        $this->bootServiceProvider();

        $consoleApp = new ConsoleApplication();
        $consoleApp->add((new SwooleServerCommand())->setContainer($this->container));

        $this->container->set(ConsoleApplication::class, $consoleApp);
        return $this;
    }

    /**
     * @param $serviceId
     * @return object
     * @throws Exception
     */
    public function get($serviceId)
    {
        return $this->container->get($serviceId);
    }

    public function loadConfig()
    {
        $config = [];
        foreach (glob($this->configPath . '/*.php') as $file) {
            $group = basename($file, '.php');
            $config[$group] = require $file;
        }

        return $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }

    protected function bootServiceProvider()
    {
        foreach ($this->config['app']['providers'] as $providerClass) {
            $provider = new $providerClass;
            $provider->setApp($this);
            $provider->setContainer($this->container);
            $provider->boot();
        }
    }

    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }
}