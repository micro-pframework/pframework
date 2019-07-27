<?php


namespace pframework\db\strategy;


interface StrategyInterface
{
    public function __construct($shardCount);

    public function shardByValue($value);
}