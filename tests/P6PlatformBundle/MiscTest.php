<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 13/04/2018
 * Time: 16:19
 */

namespace Tests\P6PlatformBundle;

use P6\PlatformBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MiscTest extends WebTestCase
{
    public function testMisc()
    {
        $this->assertEquals(2, 2);
    }

    public function testImage()
    {
        $image = new Image();
        $image->setFile('toto');
        $this->assertEquals('toto', $image->getFile());
    }

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/registration');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

}