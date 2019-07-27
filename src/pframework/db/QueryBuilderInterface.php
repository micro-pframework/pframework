<?php


namespace pframework\db;


interface QueryBuilderInterface
{
    public function __construct(ConnectionInterface $connection, $table);
}