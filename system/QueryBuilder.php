<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 6/23/18
 * Time: 12:03 PM
 */

namespace system;


class QueryBuilder
{
    protected $pdo;
    protected $query;
    protected $where;
    /**
     * @var array $columns key => value pairs of table
     */
    protected $columns;

    /**
     * QueryBuilder constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $db = Configs::getInstance()->getByName('db');
        if (empty($db)) {
            throw new \Exception("Configurations empty");
        }
        $this->pdo = new \PDO($db['dsn'], $db['db_user'], $db['db_pass']);
    }

    /**
     * @param $table
     * @param string $columns key => value paird
     * @param array $where key => $array
     * @return array
     * @throws \Exception
     */
    public function select($table, $columns = "*", $where = [], $limit = 10, $offset = 0)
    {

        if(empty($table))
            throw new \Exception("{$table} parameter required");

        $this->query = "select ";
        if (is_array($columns)) {
            foreach ($columns as $column) {
                $this->query .= $column . ",";
            }
        }
        $this->query = trim($this->query, ",");
        $this->query .= " from {$table}";


        foreach ($where as $w) {
            $this->query .= $w['column'] . $w['operator'] . ":{$w['value']}";
        }

        $this->query .= " LIMIT :offset, :limit";

        $this->query = trim($this->query, ",");

        $statement = $this->pdo->prepare($this->query);

        foreach ($where as $w) {
            $statement->bindColumn($w['column'], $w['value']);
        }

        $statement->bindColumn(":offset", $offset);
        $statement->bindColumn(":limit", $limit);

        try {
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    /**
     * @param $table
     * @param array $data key => value pair for inserting table
     * @throws \Exception
     */
    public function insert($table, $data = [])
    {
        if(!is_array($data)) {
            throw new \Exception("data param must be array key pair values");
        }
        $fields = array_keys($data);
        $this->query = "insert into {$table}(" . implode(",", $fields) . ")" .
            "VALUES(" . implode(".", array_map(function ($param) {
                return ":" . $param;
            }, $fields)) . ")";
        $statement = $this->pdo->prepare($this->query);

        foreach($data as $column => $value) {
            $statement->bindColumn(":{$column}", $value);
        }

        try {
            $statement->execute();
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    public function update($table, $data = [], $where = []) {

    }

    public function delete($table, $where = []) {

    }
}