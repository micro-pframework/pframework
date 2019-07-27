<?php

namespace pframework\db;

use pframework\db\strategy\StrategyInterface;

class MultiplyConnection implements ConnectionInterface
{
    /**
     * @var StrategyInterface
     */
    private $dbShardStrategy;

    /**
     * @var StrategyInterface[]
     */
    private $tableShardStrategy;

    private $dbShardValue;

    private $tableShardValue;

    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function setDbShardStrategy(StrategyInterface $strategy)
    {
        $this->dbShardStrategy = $strategy;
    }

    public function addTableShardStrategy(string $table, StrategyInterface $strategy)
    {
        $this->tableShardStrategy[$table] = $strategy;
    }

    public function setDbShardValue($dbShardValue)
    {
        $this->dbShardValue = $dbShardValue;
    }

    public function setTableShardValue($tableShardValue)
    {
        $this->tableShardValue = $tableShardValue;
    }

    public function table($table)
    {
        $shardDbIndex = $this->dbShardStrategy->shardByValue($this->dbShardValue);
        $shardTable = $this->tableShardStrategy[$table]->shardByValue($this->tableShardValue);
        return new QueryBuilder($this->getConnection($shardDbIndex), $shardTable);
    }

    public function getConnection($shardDbIndex)
    {
        return new Connection();
    }
}