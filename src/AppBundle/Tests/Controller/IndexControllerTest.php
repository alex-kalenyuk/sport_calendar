<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class IndexControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    public $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testIndexGuest()
    {
        $this->client->request('GET', '/');

        $this->assertTrue(
            $this->client->getResponse()->isRedirect()
        );

        $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals('/login', $this->client->getRequest()->getRequestUri());
    }
}
