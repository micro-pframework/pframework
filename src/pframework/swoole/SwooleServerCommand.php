<?php

namespace pframework\swoole;

use pframework\Application;
use Swoole\Http\Server as HttpServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SwooleServerCommand extends Command
{
    protected static $defaultName = 'run';

    protected static $swooleEventList = ['start', 'request'];

    protected static $defaualtOptions = [
        'host' => 'localhost',
        'port' => 8080,
    ];

    protected $container;

    /**
     * @param ContainerBuilder $container
     * @return $this
     */
    public function setContainer(ContainerBuilder $container)
    {
        $this->container = $container;
        return $this;
    }

    protected function configure()
    {
        $this->setDescription('启动swoole服务器.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $options = $this->parseOption($input);
        $http = new HttpServer($options['host'], $options['port']);

        $swooleEventHandler = new SwooleEventHandler($this->container);
        foreach (self::$swooleEventList as $eventName) {
            $http->on($eventName, [$swooleEventHandler, 'on' . ucfirst($eventName)]);
        }
        echo "server started at {$options['host']}:{$options['port']}..." . PHP_EOL;
        $http->start();
    }

    protected function parseOption(InputInterface $input)
    {
        $options = self::$defaualtOptions;

        $config = $this->container->get(Application::class)->getConfig();
        $options['host'] = isset($config['host']) ? $config['host'] : $options['host'];
        $options['port'] = isset($config['port']) ? $config['port'] : $options['port'];

        return $options;
    }
}