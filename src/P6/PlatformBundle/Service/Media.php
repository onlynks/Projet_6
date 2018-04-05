<?php

namespace P6\PlatformBundle\Service;


class Media
{
    public $media = null;
    public $isVideo = false;


    public function setImage($media)
    {
        $this->media = $media;
    }

    public function setVideo($video)
    {
        $this->media = $video;
        $this->isVideo = true;
    }

}