<?php

namespace Meedule\MeetingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Meedule\MeetingBundle\Entity\Meeting
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Meedule\MeetingBundle\Entity\MeetingRepository")
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
     */
    private $title;

    /**
     * @var date $date
     *
     * @ORM\Column(name="date", type="date")
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
     * @ORM\Column(name="duration", type="float")
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
     * @var datetime $createdAt
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;
    
    /**
     * @var string $email
     * 
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;
    
    /**
     * @var string $topic1
     * 
     * @ORM\Column(name="topic1", type="string", length=255)
     */
    private $topic1;
    
    /**
     * @var string $topic2
     * 
     * @ORM\Column(name="topic2", type="string", length=255, nullable="true")
     */
    private $topic2;
    
    /**
     * @var string $topic3
     * 
     * @ORM\Column(name="topic3", type="string", length=255, nullable="true")
     */
    private $topic3;
    
    /**
     * @var string $topic4
     * 
     * @ORM\Column(name="topic4", type="string", length=255, nullable="true")
     */
    private $topic4;
    
    /**
     * @var string $topic5
     * 
     * @ORM\Column(name="topic5", type="string", length=255, nullable="true")
     */
    private $topic5;
    
    /**
     * @var string $topic6
     * 
     * @ORM\Column(name="topic6", type="string", length=255, nullable="true")
     */
    private $topic6;
    
    /**
     * @var string $topic7
     * 
     * @ORM\Column(name="topic7", type="string", length=255, nullable="true")
     */
    private $topic7;
    
    /**
     * @var string $topic8
     * 
     * @ORM\Column(name="topic8", type="string", length=255, nullable="true")
     */
    private $topic8;
    
    /**
     * @var string $topic9
     * 
     * @ORM\Column(name="topic9", type="string", length=255, nullable="true")
     */
    private $topic9;
    
    /**
     * @var string $topic10
     * 
     * @ORM\Column(name="topic10", type="string", length=255, nullable="true")
     */
    private $topic10;


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
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
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
     * Set topic1
     *
     * @param string $topic1
     */
    public function setTopic1($topic1)
    {
        $this->topic1 = $topic1;
    }

    /**
     * Get topic1
     *
     * @return string 
     */
    public function getTopic1()
    {
        return $this->topic1;
    }

    /**
     * Set topic2
     *
     * @param string $topic2
     */
    public function setTopic2($topic2)
    {
        $this->topic2 = $topic2;
    }

    /**
     * Get topic2
     *
     * @return string 
     */
    public function getTopic2()
    {
        return $this->topic2;
    }

    /**
     * Set topic3
     *
     * @param string $topic3
     */
    public function setTopic3($topic3)
    {
        $this->topic3 = $topic3;
    }

    /**
     * Get topic3
     *
     * @return string 
     */
    public function getTopic3()
    {
        return $this->topic3;
    }

    /**
     * Set topic4
     *
     * @param string $topic4
     */
    public function setTopic4($topic4)
    {
        $this->topic4 = $topic4;
    }

    /**
     * Get topic4
     *
     * @return string 
     */
    public function getTopic4()
    {
        return $this->topic4;
    }

    /**
     * Set topic5
     *
     * @param string $topic5
     */
    public function setTopic5($topic5)
    {
        $this->topic5 = $topic5;
    }

    /**
     * Get topic5
     *
     * @return string 
     */
    public function getTopic5()
    {
        return $this->topic5;
    }

    /**
     * Set topic6
     *
     * @param string $topic6
     */
    public function setTopic6($topic6)
    {
        $this->topic6 = $topic6;
    }

    /**
     * Get topic6
     *
     * @return string 
     */
    public function getTopic6()
    {
        return $this->topic6;
    }

    /**
     * Set topic7
     *
     * @param string $topic7
     */
    public function setTopic7($topic7)
    {
        $this->topic7 = $topic7;
    }

    /**
     * Get topic7
     *
     * @return string 
     */
    public function getTopic7()
    {
        return $this->topic7;
    }

    /**
     * Set topic8
     *
     * @param string $topic8
     */
    public function setTopic8($topic8)
    {
        $this->topic8 = $topic8;
    }

    /**
     * Get topic8
     *
     * @return string 
     */
    public function getTopic8()
    {
        return $this->topic8;
    }

    /**
     * Set topic9
     *
     * @param string $topic9
     */
    public function setTopic9($topic9)
    {
        $this->topic9 = $topic9;
    }

    /**
     * Get topic9
     *
     * @return string 
     */
    public function getTopic9()
    {
        return $this->topic9;
    }

    /**
     * Set topic10
     *
     * @param string $topic10
     */
    public function setTopic10($topic10)
    {
        $this->topic10 = $topic10;
    }

    /**
     * Get topic10
     *
     * @return string 
     */
    public function getTopic10()
    {
        return $this->topic10;
    }
}