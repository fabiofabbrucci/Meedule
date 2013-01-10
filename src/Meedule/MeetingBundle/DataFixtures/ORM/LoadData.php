<?php
namespace Meedule\MeetingBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;
use \Datetime;
use Meedule\MeetingBundle\Entity\Meeting;

class LoadData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $meeting = new Meeting();
        $meeting->setTitle('Meeting title');
        $meeting->setDate(new DateTime);
        $meeting->setTime(new DateTime);
        $meeting->setMail('mail@drclown.it');
        $meeting->setDuration(10);
        $meeting->setName('Nome');
        $manager->persist($meeting);
        $manager->flush();
    }
}