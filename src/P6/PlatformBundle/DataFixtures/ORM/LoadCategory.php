<?php

namespace P6\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use P6\PlatformBundle\Entity\Category;

class LoadCategory implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $names = array(
            'grab',
            'Flip',
            '360',
            'slide',
            'one foot'
        );

        foreach ($names as $name) {
            $category = new Category();
            $category->setName($name);


            $manager->persist($category);
        }
        $manager->flush();
    }
}