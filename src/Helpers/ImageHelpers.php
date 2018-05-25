<?php

namespace Fei77\LaravelHelpers\Helpers;
use Image;
use File;

class ImageHelpers
{
    /**
     * The image file
     */
    protected $image;

    /**
     * Path where to save the file
     * 
     * @var string
     */
    protected $path;

    /**
     * Prefix for filename
     * 
     * @var string
     */
    protected $prefix;

    /**
     * Default image encode
     * 
     * @var string
     */
    protected $encode = 'jpg';

    /**
     * Default folder to save the file
     * 
     * @var string
     */
    protected $folder = '/images/';

    /**
     * 
     */
    public function __construct($image)
    {
        $this->path = public_path();
        $this->image = Image::make($image);
        return $this;
    }

    /**
     * Set default path for saving the file
     * 
     * @param string
     */
    public function path($path)
    {
        File::makeDirectory($path, 0775, true, true);
        $this->path = $path;
        return $this;
    }

    /**
     * Set default folder for saving the file
     * 
     * @param string
     */
    public function folder($folder)
    {
        !starts_with($folder, '/') ? $folder = '/'.$folder : $folder = $folder ;
        !ends_with($folder, '/') ? $folder = $folder.'/' : $folder = $folder ;
        File::makeDirectory($this->path.$folder, 0775, true, true);
        $this->folder = $folder;
        return $this;
    }

    /**
     * Set image encoding
     * 
     * @param string
     */
    public function encode($encode='jpg', $compression_level=95)
    {
        $this->image->encode($encode, $compression_level);
        $this->encode = $encode;
        return $this;
    }

    /**
     * Set prefix for image's filename
     * 
     * @param string
     */
    public function prefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * Save image to storage
     * 
     * @return string
     */
    public function save()
    {
        $name = $this->prefix.uniqid().'.'.$this->encode;
        $this->image->save($this->path.$this->folder.$name);
        return $this->folder.$name;
    }

    /**
     * Save image and it's thumbnail to storage
     * 
     * @return array
     */
    public function saveWithThumbnail($width=null, $height=200)
    {
        $id = uniqid();
        $name = $this->prefix.$id.'.'.$this->encode;
        $thumb = $this->prefix.$id.'_tn.'.$this->encode;
        $this->image->save($this->path.$this->folder.$name);

        $this->resizer($this->image, ['width' => $width, 'height' => $height])->save($this->path.$this->folder.$thumb);

        return [
            'originalName' => $this->folder.$name,
            'thumbnailName' => $this->folder.$thumb
        ];
    }
    
    /**
     * Resize image
     * 
     * @param int $width
     * @param int $height
     * @return void
     */
    public function resize($width = null, $height = null)
    {
        return $this->resizer($this->image, ['width' => $width, 'height' => $height]);
    }

    /**
     * Resize image
     * 
     * @param 
     */
    public function resizer($image, $size = ['width' => null, 'height' => null])
    {
        if ($size['height'] !== null && $size['width'] === null) {
            return Image::make($image->resize($size['height'], null, function($constraint) {
                $constraint->aspectRatio();
            }));
        } elseif ($size['height'] === null && $size['width'] !== null) {
            return Image::make($image->resize(null, $size['width'], function($constraint) {
                $constraint->aspectRatio();
            }));
        } elseif ($size['height'] !== null && $size['width'] !== null) {
            return Image::make($image->resize($size['height'], $size['width']));
        }
    }

}
