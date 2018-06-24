<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 6/23/18
 * Time: 10:22 AM
 */

namespace system;
class ActiveRecord
{
    protected $table;
    protected $primaryKey = 'id';
    protected $queryBuilder;


    protected $errors = [];

    /**
     * ActiveRecord constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->queryBuilder = new QueryBuilder();
    }

    /**
     * @return mixed
     */
    public function tableName()
    {
        return $this->table;
    }

    /**
     * @param bool $validation
     * @return bool
     * @throws \Exception
     */
    public function save($validation = true, $clearErrors = true)
    {
        if ($clearErrors) {
            $this->setErrorsEmpty();
        }

        if ($validation && !$this->validate()) {
            return false;
        }


        $fields = (new \ReflectionObject($this))->getProperties(\ReflectionProperty::IS_PUBLIC);
        $data = [];
        foreach ($fields as $field) {
            if($field->name === $this->primaryKey) continue;
            $data[$field->name] = $this->{$field->name};
        }
        $data = array_filter($data);
        if ($this->{$this->primaryKey} > 0) {
            return $this->queryBuilder->update($this->tableName(),
                $data,
                [
                    [
                        'column' => 'id',
                        'operator' => '=',
                        'value' => $this->{$this->primaryKey},
                    ]
                ]
            );
        } else {
            return $this->queryBuilder->insert($this->tableName(), $data);
        }
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function afterValidate()
    {
        return count($this->errors) === 0;
    }

    /**
     * @param string $name
     * @return array|mixed|null
     */
    public function getErrors($name = '')
    {
        if (empty($name)) {
            return $this->errors;
        }
        return !empty($this->errors[$name]) ? $this->errors[$name] : null;
    }

    /**
     * @void
     */
    public function setErrorsEmpty()
    {
        $this->errors = [];
    }

    /**
     * @return bool
     */
    public function validate()
    {
        if(!$this->beforeValidate())
            return false;
        return $this->afterValidate();
    }


    /**
     * @throws \Exception
     */
    public function delete()
    {
        if ($this->{$this->primaryKey}) {
            $this->queryBuilder->delete($this->tableName(), [$this->primaryKey => $this->{$this->primaryKey}]);
        }
    }

    public function findByIdentity($id = 0) {
        $items = [];
        try {
            $items = $this->queryBuilder->select(
                $this->tableName(),
                '*',
                [
                    [
                        'column' => 'id',
                        'operator' => '=',
                        'value' => $id,
                    ]
                ],
                1,
                0
            );
        } catch (\PDOException $e) {
            echo __FILE__ . " " . __LINE__ . " " . $e->getMessage();
        }

        if(count($items)) {
            return array_pop($items);
        }
        return null;
    }


    /**
     * @param int $limit
     * @param int $offset
     * @return array
     * @throws \Exception
     */
    public function search($limit = 10, $offset = 0)
    {
        $orderby = 'id';
        $order = 'desc';
        if ($sort = App::getInstance()->getRequest()->get('sort')) {
            $column = trim($sort, "-");
            if (property_exists($this, $column)) {
                $orderby = $column;;
            }
            if (strpos($sort, "-") === false) {
                $order = 'asc';
            }
        }

        try {
            $items = $this->queryBuilder->select(
                $this->tableName(),
                "*",
                [],
                $limit,
                $offset,
                $order,
                $orderby
            );
        } catch (\PDOException $e) {
            echo $e->getMessage();
            http_response_code(500);
            die();
        }

        return [
            'total' => $this->queryBuilder->count($this->tableName())->total,
            'items' => $items,
        ];
    }

    /**
     * @param array $params
     * @return bool
     */
    public function load($params = []) {
        $loaded = false;
        foreach($params as $key => $value) {
            if(property_exists($this, $key)) {
                $this->{$key} = htmlspecialchars($value);
                $loaded = true;
            }
        }
        return $loaded;
    }

}