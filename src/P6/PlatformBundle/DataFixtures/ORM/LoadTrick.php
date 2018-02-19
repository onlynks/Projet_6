<?php

namespace P6\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use P6\PlatformBundle\Entity\Trick;

class LoadTrick implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $trick = new Trick();
            $trick->setName('Trick '.$i);
            $trick->setDescription('Description '.$i);
            $manager->persist($trick);
        }

        $manager->flush();
    }
}