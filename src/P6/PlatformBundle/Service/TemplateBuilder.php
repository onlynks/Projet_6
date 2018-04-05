<?php

namespace P6\PlatformBundle\Service;

use P6\PlatformBundle\Service\Media;

class TemplateBuilder
{
    private $imagePath;

    private $medias = [];

    public function __construct($path)
    {
        $this->imagePath = $path;
    }

    public function displayMedias($images = [], $videos = [], $blocks = 0)
    {
        if($images !== null)
        {
            foreach($images as $image)
            {
                $media = new Media();
                $media->setImage($image);
                $this->medias[] = $media;
            }
        }

        if($videos !== null)
        {
            foreach($videos as $video)
            {
                $media = new Media();
                $media->setVideo($video);
                $this->medias[] = $media;
            }
        }

        if($blocks !== 0)
        {
            $this->medias = array_chunk($this->medias, $blocks);
        }

        return $this->medias;
    }

}