<?php

namespace P6\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use P6\PlatformBundle\Entity\Member;

class LoadMember implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
            for ($i = 0; $i < 20; $i++) {
            $member = new Member();
            $member->setName('Member '.$i);
            $member->setPassword('Password '.$i);
            $manager->persist($member);
        }
        $manager->flush();
    }
}