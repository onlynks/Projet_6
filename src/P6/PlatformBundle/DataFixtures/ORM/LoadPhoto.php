<?php

namespace P6\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use P6\PlatformBundle\Entity\Photo;

class LoadPhoto implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $photo = new Photo();
            $photo->setUrl('url '.$i);
            $photo->setAlt('alt '.$i);
            $manager->persist($photo);
        }

        $manager->flush();
    }
}