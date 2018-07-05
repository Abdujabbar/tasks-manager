<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 6/24/18
 * Time: 11:02 AM
 */

namespace helpers;

use Gumlet\ImageResize;
use \Gumlet\ImageResizeException;

class ImageUploader
{
    public $attribute;
    protected $name;
    protected $type;
    protected $error;
    protected $size;
    protected $tmp_name;
    protected $availableFormats = [
        'image/jpeg',
        'image/png',
        'image/gif',
    ];

    const MAX_WIDTH = 320;
    const MAX_HEIGHT = 240;
    public function __construct($attribute)
    {
        $this->attribute = $attribute;
    }

    public function processUpload()
    {
        if ($this->validate()) {
            if ($this->resizeAndSave()) {
                return $this->name;
            }
        }
        return "";
    }

    public function checkFormat()
    {
        if (!in_array($this->type, $this->availableFormats)) {
            $this->error = "available only for images with types:" . implode(",", $this->availableFormats);
            return false;
        }
        return true;
    }

    public function validate()
    {
        if (!empty($_FILES[$this->attribute])) {
            if (!empty($_FILES[$this->attribute]['name'])) {
                foreach ($_FILES[$this->attribute] as $key => $value) {
                    $this->$key = $value;
                }
                $this->name = RandomGenerator::getInstance()->randomSequence(10) . "." . pathinfo($this->name, PATHINFO_EXTENSION);

                if (!$this->checkFormat() || !$this->checkIsValidDimensions()) {
                    return false;
                }
                return true;
            }
        }
        $this->error = "{$this->attribute} cannot be empty!";
        return false;
    }

    public function checkIsValidDimensions()
    {
        list($width, $height) = getimagesize($this->tmp_name);
        if ($width < self::MAX_WIDTH || $height < self::MAX_HEIGHT) {
            $this->error = "minimum dimension must have ".self::MAX_WIDTH.'x'.self::MAX_HEIGHT;
            return false;
        }
        return true;
    }


    public static function unsetUploadedImage($name)
    {
        $path = MEDIA_PATH . DIRECTORY_SEPARATOR . $name;
        if (file_exists($path)) {
            unset($path);
        }
    }

    /**
     * @return bool
     */
    public function resizeAndSave()
    {
        try {
            $imageResize = new ImageResize($this->tmp_name);
            $imageResize->resizeToBestFit(self::MAX_WIDTH, self::MAX_HEIGHT);
            $imageResize->save(MEDIA_PATH . DIRECTORY_SEPARATOR . $this->name);
            return true;
        } catch (ImageResizeException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function getError()
    {
        return $this->error;
    }
}
