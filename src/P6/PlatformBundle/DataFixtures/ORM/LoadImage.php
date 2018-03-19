<?php

namespace P6\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use P6\PlatformBundle\Entity\Image;

class LoadImage implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $image = new Image();
            $image->setFile('file '.$i);
            $manager->persist($image);
        }

        $manager->flush();
    }
}