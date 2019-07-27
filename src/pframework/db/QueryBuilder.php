<?php


namespace pframework\db;


class QueryBuilder implements QueryBuilderInterface
{
    /**
     * @var ConnectionInterface $connection
     */
    private $connection;

    private $table;

    public function __construct(ConnectionInterface $connection, $table)
    {
        $this->connection = $connection;
        $this->table = $table;
    }

    public function select($field)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->where} LIMIT {$this->limit}";


    }
}