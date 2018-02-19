<?php

namespace P6\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use P6\PlatformBundle\Entity\Message;

class LoadMessage implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $message = new Message();
            $message->setContent('message '.$i);
            $message->setDate(new \DateTime());
            $manager->persist($message);
        }

        $manager->flush();
    }
}