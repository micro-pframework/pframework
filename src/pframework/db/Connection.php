<?php


namespace pframework\db;

use PDO;


class Connection extends PDO implements ConnectionInterface
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
        parent::__construct();
    }

    public function table($table)
    {
        // TODO: Implement table() method.
    }

}