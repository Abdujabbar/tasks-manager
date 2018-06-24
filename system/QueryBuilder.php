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
        try {
            $this->pdo = new \PDO($db['dsn'], $db['db_user'], $db['db_pass']);
        } catch (\PDOException $e) {
            echo $e->getMessage() . " " . __FILE__ . ":". __LINE__;
            die();
        }
    }

    public function count($table)
    {
        $query = "select count(*) as total from {$table}";

        try {
            $statement = $this->pdo->query($query);
            $statement->execute();
            return $statement->fetch(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    /**
     * @param $table
     * @param string $columns
     * @param array $where
     * @param int $limit
     * @param int $offset
     * @param string $order
     * @return array
     * @throws \Exception
     */
    public function select($table, $columns = "*", $where = [], $limit = 10, $offset = 0, $order = 'desc', $orderby = 'id')
    {

        if (empty($table))
            throw new \Exception("{$table} parameter required");

        $query = "select ";
        if (is_array($columns)) {
            foreach ($columns as $column) {
                $query .= $column . ",";
            }
        } else {
            $query .= " {$columns} ";
        }

        $query = trim($query, ",");

        $query .= " from {$table}";


        $query .= $this->buildWhereCondition($where);

        $query .= " order by {$orderby} $order";

        $query .= " LIMIT :offset, :limit";

        $statement = $this->pdo->prepare($query);

        foreach ($where as $w) {
            $statement->bindParam(":{$w['column']}", $w['value']);
        }

        $statement->bindParam(":offset", $offset, \PDO::PARAM_INT);
        $statement->bindParam(":limit", $limit, \PDO::PARAM_INT);
        try {
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    /**
     * @param $table
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function insert($table, $data = [])
    {
        if (!is_array($data)) {
            throw new \Exception("data param must be array key pair values");
        }
        $fields = array_keys($data);
        $query = "insert into {$table}(" . implode(",", $fields) . ")" .
            " VALUES(" . implode(",", array_map(function ($param) {
                return ":" . $param;
            }, $fields)) . ")";
        $statement = $this->pdo->prepare($query);

        foreach($data as $column => $value) {
            $statement->bindValue(":$column", $value);
        }

        try {
            return $statement->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();die();
            throw $e;
        }
    }

    /**
     * @param $table
     * @param array $data
     * @param array $where
     * @return bool
     * @throws \Exception
     */
    public function update($table, $data = [], $where = [])
    {
        if(isset($data['created_at'])) {
            unset($data['created_at']);
        }
        $query = "update {$table} SET ";
        foreach ($data as $column => $value) {
            $query .= "{$column}=:$column,";
        }
        $query = trim($query, ",");
        $query .= $this->buildWhereCondition($where);

        $statement = $this->pdo->prepare($query);
        foreach ($data as $column => $value) {
            $statement->bindValue(":$column", $value);
        }

        foreach ($where as $w) {
            $statement->bindParam(":{$w['column']}", $w['value']);
        }

        try {
            return $statement->execute();
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    /**
     * @param array $where
     * @return string
     * @throws \Exception
     */
    private function buildWhereCondition($where = [])
    {
        $whereCondition = "";
        $whereConditionParams = ['column', 'operator', 'value'];
        foreach ($where as $w) {
            if (count(array_diff($whereConditionParams, array_keys($w)))) {
                throw new \Exception("where array must have 3 fields: column, operator, value");
                die();
            }
            $whereCondition .= "AND " . $w['column'] . $w['operator'] . ":{$w['column']}";
        }
        if ($whereCondition) {
            $whereCondition = trim($whereCondition, "AND");
            $whereCondition = " WHERE {$whereCondition}";
        }
        return $whereCondition;
    }

    /**
     * @param $table
     * @param array $where
     * @return bool
     * @throws \Exception
     */
    public function delete($table, $where = [])
    {
        $query = "delete from {$table}";
        $query .= $this->buildWhereCondition($where);


        $statement = $this->pdo->prepare($query);

        foreach ($where as $w) {
            $statement->bindColumn(":{$w["column"]}", $w['value']);
        }

        try {
            return $statement->execute();
        } catch (\PDOException $e) {
            throw $e;
        }
    }
}