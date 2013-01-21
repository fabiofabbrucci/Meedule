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

    public function __construct()
    {
        parent::__construct();
        $this->meetings = new ArrayCollection;
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
}