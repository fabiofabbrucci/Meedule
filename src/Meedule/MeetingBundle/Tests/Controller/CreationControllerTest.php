<?php

namespace Meedule\MeetingBundle\Tests\Controller;

use Meedule\MeetingBundle\Tests\Controller\WebTestCase;

class CreationControllerTest extends WebTestCase
{
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Crea il tuo primo meeting')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Avanti')->form(array(
            'meedule_meetingbundle_meetingtype[title]'  => 'Titolo meeting',
            'meedule_meetingbundle_meetingtype[mail]'  => 'mail@drclown.it',
            'meedule_meetingbundle_meetingtype[name]'  => 'Fabio',
            'meedule_meetingbundle_meetingtype[duration]'  => '60',
        ));
        
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertEquals($crawler->filter('input#meedule_meetingbundle_topictype_name')->count(), 1);
        $this->assertEquals($crawler->filter('ol li')->count(), 0);
        
        $form = $crawler->selectButton('Aggiungi')->form(array(
            'meedule_meetingbundle_topictype[name]'  => 'Titolo topic',
        ));
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertEquals($crawler->filter('ol li')->count(), 1);
        
        $form = $crawler->selectButton('Aggiungi')->form(array(
            'meedule_meetingbundle_topictype[name]'  => 'Titolo topic 2',
        ));
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertEquals($crawler->filter('ol li')->count(), 2);
        
        $form = $crawler->selectButton('clicca qui')->form();
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertEquals($crawler->filter('h1:contains("Titolo meeting")')->count(), 1);
        $this->assertEquals($crawler->filter('b:contains("mail@drclown.it")')->count(), 1);
        
    }
    
}