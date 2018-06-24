<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 6/23/18
 * Time: 10:52 PM
 */

namespace models;

use helpers\ImageUploader;
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
    const STATUS_DECLINED = 0;
    const STATUS_PENDING = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_CLOSED = 3;

    /**
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_DECLINED => 'declined',
            self::STATUS_PENDING => 'pending',
            self::STATUS_IN_PROGRESS => 'in progress',
            self::STATUS_CLOSED => 'closed',
        ];
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public static function getStatusLabel($status = '')
    {
        $labels = self::getStatusList();
        return !empty($labels[$status]) ? $labels[$status] : null;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        $this->beforeValidate();
        $fields = (new \ReflectionObject($this))->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach ($fields as $field) {
            if ($field->name === $this->primaryKey) continue;
            if (!empty($this->errors[$field->name])) continue;
            if (empty($this->{$field->name})) {
                $this->errors[$field->name] = "{$field->name} cannot be empty";
            }

            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $this->errors['email'] = 'Email field must contain valid email address';
            }
        }

        return $this->afterValidate();
    }

    /**
     * @return bool
     */
    public function afterValidate()
    {
        if (parent::afterValidate())
            return true;

        ImageUploader::unsetUploadedImage($this->image);
        return false;
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if (!$this->id) {
            $this->created_at = time();
            $this->status = self::STATUS_PENDING;
        }
        $this->updated_at = time();

        if (parent::beforeValidate()) {
            $imageUploader = new \helpers\ImageUploader('image');
            if (($image = $imageUploader->processUpload())) {
                $this->image = $image;
            } else {
                if(!$this->image) {
                    $this->errors['image'] = $imageUploader->getError();
                }
            }
        }
        return true;
    }


}