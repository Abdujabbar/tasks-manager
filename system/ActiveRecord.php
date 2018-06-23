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
    protected $query;

    /**
     * ActiveRecord constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->query = new QueryBuilder();
    }


    public function tableName() {
        return $this->table;
    }

    /**
     * @throws \Exception
     */
    public function save() {
        $fields = (new \ReflectionObject($this))->getProperties(\ReflectionProperty::IS_PUBLIC);
        $data = [];
        foreach($fields as $field) {
            $data[$field->name] = $this->{$field->name};
        }
        $data = array_filter($data);
        if($this->{$this->primaryKey} > 0) {
            $this->query->update($this->tableName(), $data, [$this->primaryKey => $this->{$this->primaryKey}]);
        } else {
            $this->query->insert($this->tableName(), $data);
        }
    }


    public function delete() {
        if($this->{$this->primaryKey}) {
            $this->query->delete($this->tableName(), [$this->primaryKey => $this->{$this->primaryKey}]);
        }
    }



}