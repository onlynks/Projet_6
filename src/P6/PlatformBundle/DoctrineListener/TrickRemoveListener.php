<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 21/03/2018
 * Time: 17:36
 */

namespace P6\PlatformBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use P6\PlatformBundle\Entity\Trick;
use P6\PlatformBundle\Service\ImageEraser;


class TrickRemoveListener
{
    private $ImageEraser;

    public function __construct(ImageEraser $ImageEraser)
    {
        $this->ImageEraser = $ImageEraser;
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Trick) {
            return;
        }
        $images = $entity->getImages();
        $files = [];

        foreach($images as $image)
        {
            $files[] = $image->getFile();
        }

        $this->ImageEraser->delete($files);
    }

}