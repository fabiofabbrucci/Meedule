<?php

namespace Meedule\MeetingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Meedule\MeetingBundle\Entity\Reference
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Reference
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string $owner
     *
     * @ORM\Column(name="owner", type="string", length=255, nullable="true")
     */
    private $owner;
    
    /**
     * @ORM\ManyToOne(targetEntity="Meedule\MeetingBundle\Entity\Meeting", inversedBy="references")
     * @ORM\JoinColumn(name="meeting_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $meeting;
    
    private $delete_form;


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
     * Set url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set owner
     *
     * @param string $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * Get owner
     *
     * @return string 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set meeting
     *
     * @param Meedule\MeetingBundle\Entity\Meeting $meeting
     */
    public function setMeeting(\Meedule\MeetingBundle\Entity\Meeting $meeting)
    {
        $this->meeting = $meeting;
    }

    /**
     * Get meeting
     *
     * @return Meedule\MeetingBundle\Entity\Meeting 
     */
    public function getMeeting()
    {
        return $this->meeting;
    }
    
    public function setDeleteForm($form){
        $this->delete_form = $form;
    }
    
    public function getDeleteForm(){
        return $this->delete_form;
    }
}