<?php

namespace Meedule\MeetingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Meedule\MeetingBundle\Entity\Attendee
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Attendee
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
     * @var string $mail
     *
     * @ORM\Column(name="mail", type="string", length=255, nullable="true")
     */
    private $mail;

    /**
     * @ORM\ManyToOne(targetEntity="Meedule\MeetingBundle\Entity\Meeting", inversedBy="attendees")
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
     * Get mail
     *
     * @return string 
     */
    public function getGravatarMail()
    {
        if($this->mail){
            return md5(strtolower($this->mail));
        }
        return false;
    }
}