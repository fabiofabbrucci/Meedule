<?php

namespace Meedule\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use \Doctrine\Common\Collections\ArrayCollection;
use Meedule\MeetingBundle\Entity\Meeting;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\OneToMany(targetEntity="Meedule\MeetingBundle\Entity\Meeting", mappedBy="owner")
     */
    protected $meetings;
    
    /**
     * @ORM\OneToMany(targetEntity="Meedule\MeetingBundle\Entity\Attendee", mappedBy="user")
     */
    protected $partecipations;
    
    /**
     * @ORM\OneToMany(targetEntity="Meedule\MeetingBundle\Entity\Topic", mappedBy="user")
     */
    protected $topics;

    public function __construct()
    {
        parent::__construct();
        $this->meetings = new ArrayCollection;
        $this->partecipations = new ArrayCollection;
        $this->topics = new ArrayCollection;
    }
    
    public function getGravatarMail()
    {
        if($this->email){
            return md5(strtolower($this->email));
        }
        return false;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Add meetings
     *
     * @param Meedule\MeetingBundle\Entity\Meeting $meetings
     */
    public function addMeeting(\Meedule\MeetingBundle\Entity\Meeting $meeting)
    {
        $this->meetings[] = $meeting;
    }

    /**
     * Get meetings
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMeetings()
    {
        return $this->meetings;
    }

    /**
     * Add partecipations
     *
     * @param Meedule\MeetingBundle\Entity\Attendee $partecipations
     */
    public function addAttendee(\Meedule\MeetingBundle\Entity\Attendee $partecipation)
    {
        $this->partecipations[] = $partecipation;
    }

    /**
     * Get partecipations
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPartecipations()
    {
        return $this->partecipations;
    }

    /**
     * Add topics
     *
     * @param Meedule\MeetingBundle\Entity\Topic $topics
     */
    public function addTopic(\Meedule\MeetingBundle\Entity\Topic $topics)
    {
        $this->topics[] = $topics;
    }

    /**
     * Get topics
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTopics()
    {
        return $this->topics;
    }
}