<?php

namespace Meedule\MeetingBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase as LiipWebTestCase;

abstract class WebTestCase extends LiipWebTestCase
{
    function setUp(){
        $classes = array(
            'Meedule\MeetingBundle\DataFixtures\ORM\LoadData',
        );

        $this->loadFixtures($classes);
    }
    
    function getClient(){
        return $this->makeClient();
    }
    
    function loadApp()
    {
        $app = new \stdClass();
        //$app->client = $this->makeClient(array('username' => $username, 'password' => $password));
        $app->client = $this->makeClient();
        $app->client->followRedirects(true);
        $app->container = $app->client->getContainer();
        $app->router = $app->container->get('router');
        $app->em = $app->container->get('doctrine.orm.entity_manager');
        $app->tr = $app->container->get('translator');

        return $app;
    }
    
    protected function showInBrowser($client)
    {
        $kernel = $client->getKernel();
        file_put_contents($kernel->getRootDir().'/cache/output.html', $client->getResponse()->getContent());
        exec('chromium-browser '.$kernel->getRootDir().'/cache/output.html');
    }
}