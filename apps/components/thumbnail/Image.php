<?php
namespace Apps\Components\Thumbnail;

use Cygnite\Cygnite;
use Cygnite\Helpers\Inflectors;

/**
 *  Cygnite framework
 *
 *  An open source application development framework for PHP 5.3x or newer
 *
 *   License
 *
 *   This source file is subject to the MIT license that is bundled
 *   with this package in the file LICENSE.txt.
 *   http://www.cygniteframework.com/license.txt
 *   If you did not receive a copy of the license and are unable to
 *   obtain it through the world-wide-web, please send an email
 *   to sanjoy@hotmail.com so I can send you a copy immediately.
 *
 * @package              Apps
 * @subpackages          Thumbnail Image Components
 * @filename             Thumbnail
 * @description          Thumbnail component is used to generate thumb images from given configurations
 * @author               Sanjoy Dey
 * @copyright            Copyright (c) 2013 - 2014,
 * @link	             http://www.cygniteframework.com
 * @since	             Version 1.0
 * @filesource
 * @warning              Any changes in this library can cause abnormal behaviour of the framework
 *
 * @example
 * <code>
 *    Example:
 *    $thumb = new \Apps\Components\Thumbnail\Image();
 *    $thumb->directory = 'Set your directory path';
 *    $thumb->fixedWidth  = 100;
 *    $thumb->fixedHeight = 100;
 *    $thumb->thumbPath = 'your thumb path';
 *    $thumb->thumbName = 'Your thumb image name';
 *    // Optional. If you doen't want to have custom name then it will generate
 *    thumb as same name of original image.
 *    $thumb->resize();
 * </code>
 */

class Image
{
    //defined thumbs array to hold dynamic properties
    public $thumbs = array();

    //Set valid types of images to convert to thumb
    public $imageTypes = array("jpg","png","jpeg","gif");

    //Set valid type of properties to avoid exceptions
    private $validProperties = array('directory', 'fixedWidth', 'fixedHeight', 'thumbPath', 'thumbName');

    /**
     * @param $key   name of the property
     * @param $value value to set
     * @throws \Exception
     * @return void
     */
    public function __set($key, $value)
    {
        if (in_array($key, $this->validProperties) == false) {
            throw new \Exception('You are not allowed to set invalid properties. Please check guide.');
        }
        $this->thumbs[$key] = $value;
    }

    /**
     * @param $key property name
     * @return string
     */
    public function __get($key)
    {
        if (isset($this->thumbs[$key])) {
              return $this->thumbs[$key];
        }
    }

    /**
     * Resize image as given configurations
     *
     * @throws \Exception
     * @return boolean
     */
    public function resize()
    {
        $path = array();
        $src = getcwd().DS.str_replace(array('/','\\'), DS, $this->directory);	 /* read the source image */


        if (file_exists($src)) {
            $info = getimagesize($src); // get the image size
            $path = pathinfo($src);

            if (!in_array(strtolower($path['extension']), $this->imageTypes)) {
                throw new \Exception("File type not supports");
            }

            $thumbName = ($this->thumbName == null)
                         ? $path['basename']
                         : $this->thumbName.'.'.$path['extension'];


            switch (strtolower($path['extension'])) {

                case 'jpg':
                    $sourceImage =$this->imageCreateFrom('jpeg', $src);
                    $thumbImg = $this->changeDimensions($sourceImage, $this->fixedWidth, $this->fixedHeight);
                    $this->image('jpeg', $thumbImg, $thumbName);

                    break;
                case 'png':

                    $sourceImage =$this->imageCreateFrom('png', $src);
                    $thumbImg=$this->changeDimensions($sourceImage, $this->fixedWidth, $this->fixedHeight);
                    $this->image('png', $thumbImg, $thumbName);

                    break;
                case 'jpeg':

                    $sourceImage =$this->imageCreateFrom('jpeg', $src);
                    $thumbImg=$this->changeDimensions($sourceImage, $this->fixedWidth, $this->fixedHeight);
                    $this->image('jpeg', $thumbImg, $thumbName);

                    break;
                case 'gif':
                    $sourceImage =$this->imageCreateFrom('jpeg', $src);
                    $thumbImg=$this->changeDimensions($sourceImage, $this->fixedWidth, $this->fixedHeight);
                    $this->image('gif', $thumbImg, $thumbName);

                    break;
            }

            return true;

        } else {
              throw new \Exception("404 File not found on given path");
        }
    }

    /**
     * @param      $type type of the image
     * @param      $src  image source
     * $param null function name to build dynamically
     * @param null $func
     * @return source image
     */
    private function imageCreateFrom($type, $src, $func = null)
    {
        $func = Inflector::instance()s->changeToLower(__FUNCTION__.$type);

        return (is_callable($func))
            ? $func($src)
            : null;

    }

    /**
     * @param      $type type of the image
     * @param      $thumb
     * @param      $name
     * @param null $func
     * @throws \Exception
     * @internal param \Apps\Components\Libraries\image $src source
     * $param null function name to build dynamically
     * @return sourceImage
     */
    private function image($type, $thumb, $name, $func = null)
    {
        $func = Inflector::instance()s->changeToLower(__FUNCTION__.$type);

        /** @var $func TYPE_NAME */
        //if (is_callable($func)) {
        if ($func(
                $thumb,
                getcwd().DS.str_replace(
                    array(
                        '/',
                        '\\'
                    ),
                    DS,
                    $this->thumbPath
                ).$name
            )
            ) {
                chmod(getcwd().DS.str_replace(array('/', '\\'), DS, $this->thumbPath).$name, 0777);
        } else {
                throw new \Exception("Unknown Exception  while generating thumb image");
        }
    }

    /**
     * Change dimension of the image
     * @param $sourceImage
     * @param $desiredWidth
     * @param $desiredHeight
     * @internal param \Apps\Components\Libraries\type $type of the image
     * @internal param \Apps\Components\Libraries\image $src source
     *
     * @return thumbImage
     */
    public function changeDimensions(
        $sourceImage,
        $desiredWidth,
        $desiredHeight
    ) {
        $temp = "";
        // find the height and width of the image
        if (imagesx($sourceImage) >= imagesy($sourceImage)
            && imagesx($sourceImage) >= $this->fixedWidth
        ) {
            $temp = imagesx($sourceImage) / $this->fixedWidth;
            $desiredWidth  = imagesx($sourceImage)/$temp;
            $desiredHeight = imagesy($sourceImage)/$temp;
        } elseif (imagesx($sourceImage) <= imagesy($sourceImage)
            && imagesy($sourceImage) >=$this->fixedHeight
        ) {
            $temp = imagesy($sourceImage)/$this->fixedHeight;
            $desiredWidth  = imagesx($sourceImage) /$temp;
            $desiredHeight = imagesy($sourceImage)/$temp;
        } else {
            $desiredWidth  = imagesx($sourceImage);
            $desiredHeight = imagesy($sourceImage);
        }

        // create a new image
        $thumbImg = imagecreatetruecolor($desiredWidth, $desiredHeight);
        $imgAllocate =imagecolorallocate($thumbImg, 255, 255, 255);
        imagefill($thumbImg, 0, 0, $imgAllocate);

        //copy source image to resize
        imagecopyresampled(
            $thumbImg,
            $sourceImage,
            0,
            0,
            0,
            0,
            $desiredWidth,
            $desiredHeight,
            imagesx($sourceImage),
            imagesy($sourceImage)
        );

        return $thumbImg;
    }

    public function __destruct()
    {
        unset($this->thumbs);
    }
}
