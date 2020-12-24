<?php

class img
{

    protected $image;
    protected $image_type;
    protected $path;
    protected $width;
    protected $height;
    protected $image_info;

    function __construct($filename, $width = '', $height = '', $save = '0', $type = 'upload')
    {
        // Basics
        if ($type == 'attachment') {
            $this->path       = PP_PATH . '/custom/sd-system/attachments/' . $filename;
        } else {
            $this->path       = PP_PATH . '/custom/uploads/' . $filename;
        }
        $this->width      = $width;
        $this->height     = $height;
        $image_info       = getimagesize($this->path);
        $this->image_info = $image_info;
        if (!empty($width) && $image_info['0'] <= $this->width) {
            $this->width = $image_info['0'];
        }
        if (!empty($height) && $image_info['1'] <= $this->height) {
            $this->height = $image_info['1'];
        }
        // Image type
        $this->image_type = $image_info['mime'];
        if ($this->image_type == 'image/jpeg') {
            $this->image = imagecreatefromjpeg($this->path);
        }
        elseif ($this->image_type == 'image/gif') {
            $this->image = imagecreatefromgif($this->path);
        }
        elseif ($this->image_type == 'image/png') {
            $this->image = imagecreatefrompng($this->path);
        }
        // What are we doing?
        if (!empty($this->width)) {
            $this->resizeToWidth();
            if ($save == '1') {
                $this->save();
            } else {
                $this->output();
            }
        } else if (!empty($this->height)) {
            $this->resizeToHeight();
            $this->output();
            if ($save == '1') {
                $this->save();
            } else {
                $this->output();
            }
        } else {
            // nothing...
        }
    }

    function save()
    {
        if ($this->image_type == 'image/jpeg') {
            imagejpeg($this->image, $this->path, '100');

        } else if ($this->image_type == 'image/gif') {
            imagegif($this->image, $this->path);

        } else if ($this->image_type == 'image/png') {
            imagepng($this->image, $this->path);

        }

    }

    function output()
    {
        if ($this->image_type == 'image/jpeg') {
            header('Content-type: image/jpeg');
            imagejpeg($this->image);
        } elseif ($this->image_type == 'image/gif') {
            header('Content-type: image/gif');
            imagegif($this->image);
        } elseif ($this->image_type == 'image/png') {
            header('Content-type: image/png');
            imagepng($this->image);
        }
    }

    function getWidth()
    {
        //return imagesx($this->image);
        return $this->image_info['0'];

    }

    function getHeight()
    {
        //return imagesy($this->image);
        return $this->image_info['1'];

    }

    function resizeToHeight()
    {
        $ratio    = $this->height / $this->getHeight();
        $newwidth = $this->getWidth() * $ratio;
        $this->resize($newwidth, $this->height);

    }

    function resizeToWidth()
    {
        $ratio     = $this->width / $this->getWidth();
        $newheight = $this->getheight() * $ratio;
        $this->resize($this->width, $newheight);

    }

    function resize($width, $height)
    {
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;

        //imagedestroy($this->image);
    }

}

