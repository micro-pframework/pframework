<?php

namespace app\provider;

use pframework\AbstractServiceProvider;
use pframework\db\Connection;
use pframework\db\MultiplyConnection;

class DbProvider extends AbstractServiceProvider
{
    public function boot()
    {
        $config = $this->app->getConfig();
        // 分库
        if (isset($config['db']['mutiply'])) {
            $multiplyConnectionsConfig = $config['db']['multiply'];
            $multiplyConnection = new MultiplyConnection($multiplyConnectionsConfig);

            $multiplyConnection->setDbShardStrategy(new $multiplyConnectionsConfig['strategy']);

            foreach ($multiplyConnectionsConfig['multiply']['table'] as $tableName => $shardTableConfig) {
                $tableStrategy = new $shardTableConfig['strategy']($shardTableConfig['shard']);
                $multiplyConnection->addTableShardStrategy($tableName, $tableStrategy);
            }

            $this->container->set("testShardDb", $multiplyConnection);
        }

        // 单库
        if (isset($config['db']['single'])) {
            $connection = new Connection($config['db']['single']);
            $this->container->set("testDb", $connection);
        }
    }
}