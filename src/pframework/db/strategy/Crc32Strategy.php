<?php


namespace pframework\db\strategy;


class Crc32Strategy implements StrategyInterface
{
    private $shardCount;

    public function __construct($shardCount)
    {
        $this->shardCount = $shardCount;
    }

    public function shardByValue($value)
    {
        return (sprintf("%u", crc32($value)) >> 16 & 0x7fff) % $this->shardCount;
    }
}