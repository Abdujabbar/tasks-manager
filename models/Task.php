<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 6/23/18
 * Time: 10:52 PM
 */

namespace models;

use system\ActiveRecord;
use system\App;

class Task extends ActiveRecord
{
    protected $table = 'tasks';
    public $id;
    public $username;
    public $email;
    public $content;
    public $image;
    public $status;
    public $created_at;
    public $updated_at;
    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in-progress';
    const STATUS_SUCCESS = 'success';


    protected $availableFormatsForUpload = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if (!$this->id) {
                $this->created_at = time();
            } else {
                $this->updated_at = time();
            }
            $this->validatePostedImage();
            $fields = (new \ReflectionObject($this))->getProperties(\ReflectionProperty::IS_PUBLIC);
            foreach ($fields as $field) {
                if (empty($this->{$field->name}) && empty($this->errors[$this->{$field->name}])) {
                    $this->errors[$field->name] = "{$field->name} cannot be empty";
                }
            }
        }
    }

    protected function validatePostedImage()
    {
        var_dump($_FILES);
        die();
        if (isset($_FILES['image'])) {
            if (!empty($_FILES['image']['name'])) {

            }
        }
    }


}