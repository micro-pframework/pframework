<?php


namespace pframework\db\strategy;


class ModStrategy implements StrategyInterface
{
    private $shardCount;

    public function __construct($shardCount)
    {
        $this->shardCount = $shardCount;
    }

    public function shardByValue($value)
    {
        return $value % $this->shardCount;
    }

}