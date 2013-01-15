<?php

namespace Meedule\MeetingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Meedule\MeetingBundle\Entity\Meeting
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Meedule\MeetingBundle\Entity\MeetingRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Meeting
{
    function __construct(){
        $this->setCreatedAt(new \DateTime());
    }
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var date $date
     *
     * @ORM\Column(name="date", type="date", nullable="true")
     */
    private $date;
    
    /**
     * @var time $time
     *
     * @ORM\Column(name="time", type="time", nullable="true")
     */
    private $time;
    
    /**
     * @var int $duration
     *
     * @ORM\Column(name="duration", type="float", nullable="true")
     */
    private $duration;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", nullable="true")
     */
    private $description;

    /**
     * @var text $address
     *
     * @ORM\Column(name="address", type="text", nullable="true")
     */
    private $address;
    
    /**
     * @var boolea $closed
     *
     * @ORM\Column(name="closed", type="boolean", nullable="true")
     */
    private $closed;
    
    /**
     * @var datetime $closedAt
     *
     * @ORM\Column(name="closedAt", type="datetime", nullable="true")
     */
    private $closedAt;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;
    
    /**
     * @var string $slugpublic
     *
     * @ORM\Column(name="slugpublic", type="string", length=32, unique=true)
     */
    private $slugpublic;
    
    /**
     * @var string $slugprivate
     *
     * @ORM\Column(name="slugprivate", type="string", length=32, unique=true)
     */
    private $slugprivate;
    
    /**
     * @var string $mail
     * 
     * @ORM\Column(name="mail", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $mail;
    
    /**
     * @var string $name
     * 
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;
    
    /**
     * @ORM\OneToMany(targetEntity="Meedule\MeetingBundle\Entity\User", mappedBy="meeting", cascade={"persist", "remove"})
     */
    private $attendees;
    
    /**
     * @ORM\OneToMany(targetEntity="Meedule\MeetingBundle\Entity\Topic", mappedBy="meeting", cascade={"persist", "remove"})
     * @ORM\OrderBy({"position" = "ASC", "id" = "ASC"})
     */
    private $topics;
    
    /**
     * @var string $doodle
     *
     * @ORM\Column(name="doodle", type="string", length=255, nullable="true")
     */
    private $doodle;
    
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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set address
     *
     * @param text $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return text 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set mail
     *
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set duration
     *
     * @param float $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * Get duration
     *
     * @return float 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set date
     *
     * @param date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return date 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set time
     *
     * @param time $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * Get time
     *
     * @return time 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set slugpublic
     *
     * @param string $slugpublic
     */
    public function setSlugpublic($slugpublic)
    {
        $this->slugpublic = $slugpublic;
    }

    /**
     * Get slugpublic
     *
     * @return string 
     */
    public function getSlugpublic()
    {
        return $this->slugpublic;
    }

    /**
     * Set slugprivate
     *
     * @param string $slugprivate
     */
    public function setSlugprivate($slugprivate)
    {
        $this->slugprivate = $slugprivate;
    }

    /**
     * Get slugprivate
     *
     * @return string 
     */
    public function getSlugprivate()
    {
        return $this->slugprivate;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
    * @ORM\PrePersist
    */
    public function setSlugs()
    {
        if(!$this->getSlugpublic()){
            $data = new \DateTime();
            $string = $this->getTitle() . $this->getMail() . $data->format('YmsHis') . rand(1,1000000);
            $this->setSlugpublic(md5($string));
            $this->setSlugprivate(md5(strrev($string)));
        }
    }

    /**
     * Add attendees
     *
     * @param Meedule\MeetingBundle\Entity\User $attendees
     */
    public function addUser(User $attendees)
    {
        $this->attendees[] = $attendees;
    }

    /**
     * Get attendees
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAttendees()
    {
        return $this->attendees;
    }
    
    public function hasAttendee(User $attendee){
        $key = $this->attendees->indexOf($attendee);
        if($key===FALSE) 
        {
            return false;
        }
        return true;
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
    
    /**
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAgendaTopics()
    {
        $topics = new ArrayCollection;
        foreach ($this->getTopics() as $topic) {
            if (!$topic->getOwner()) {
                $topics->add($topic);
            }
        }

        return $topics;
    }
    
    /**
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCrewTopics()
    {
        $topics = new ArrayCollection;
        foreach ($this->getTopics() as $topic) {
            if ($topic->getOwner()) {
                $topics->add($topic);
            }
        }

        return $topics;
    }

    /**
     * Set doodle
     *
     * @param string $doodle
     */
    public function setDoodle($doodle)
    {
        $this->doodle = $doodle;
    }

    /**
     * Get doodle
     *
     * @return string 
     */
    public function getDoodle()
    {
        return $this->doodle;
    }
    
    public function setAgendaTopics(ArrayCollection $topics){}
    
    public function setCrewTopics(ArrayCollection $topics){}

    /**
     * Set closed
     *
     * @param boolean $closed
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;
    }

    /**
     * Get closed
     *
     * @return boolean 
     */
    public function getClosed()
    {
        return $this->closed;
    }

    /**
     * Set closedAt
     *
     * @param datetime $closedAt
     */
    public function setClosedAt($closedAt)
    {
        $this->closedAt = $closedAt;
    }

    /**
     * Get closedAt
     *
     * @return datetime 
     */
    public function getClosedAt()
    {
        return $this->closedAt;
    }
    
    /**
     * Is Closed
     *
     * @return boolean 
     */
    public function isClosed()
    {
        return $this->closed;
    }
}