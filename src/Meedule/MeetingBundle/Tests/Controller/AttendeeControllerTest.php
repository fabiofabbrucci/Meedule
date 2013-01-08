<?php

namespace Meedule\MeetingBundle\Tests\Controller;

use Meedule\MeetingBundle\Tests\Controller\WebTestCase;

class AttendeeControllerTest extends WebTestCase
{
    public function testAddAttendee()
    {
        // Create a new client to browse the application
        $app = $this->loadApp();
        $client = $app->client;
        
        $meeRepo = $app->em->getRepository('MeeduleMeetingBundle:Meeting');
        $meeting = $meeRepo->findOneByTitle('Meeting title');
        
        $rotta = $app->router->generate('meeting_show', array('slug' => $meeting->getSlugpublic()));
        // Create a new entry in the database
        $crawler = $client->request('GET', $rotta);
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $this->assertEquals($crawler->filter('#attendees li')->count(), 0);
        
        $form = $crawler->selectButton('Partecipa')->form(array(
            'meedule_meetingbundle_attendeetype[name]'  => 'Fabio',
        ));
        $client->submit($form);
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        //$this->assertEquals($crawler->filter('li:contains("Fabio")')->count(), 1);
        //$this->assertEquals($crawler->filter('#attendees ol > li')->count(), 1);
        
    }
}