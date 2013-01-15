<?php

namespace Meedule\MeetingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Meedule\MeetingBundle\Form\Type\DoodleType;
use Meedule\MeetingBundle\Form\Type\MailType;
use Meedule\MeetingBundle\Entity\Meeting;
use Doctrine\ORM\EntityRepository;

class CloseType extends AbstractType
{
    private $meeting;
    
    function __construct(Meeting $meeting) {
        $this->meeting = $meeting;
    }
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $meeting = $this->meeting;
        $builder
            ->add('AgendaTopics', 'entity', array(
                'class' => 'MeeduleMeetingBundle:Topic',
                'query_builder' => function(EntityRepository $tr) use ($meeting) {
                         return $tr->getAgendaTopicsByMeeting($meeting);
                       },
                'multiple' => true,
                'expanded' => true,
            ))
            ->add('CrewTopics', 'entity', array(
                'class' => 'MeeduleMeetingBundle:Topic',
                'query_builder' => function(EntityRepository $tr) use ($meeting) {
                         return $tr->getCrewTopicsByMeeting($meeting);
                       },
                'multiple' => true,
                'expanded' => true,
            ))
        ;
    }

    public function getName()
    {
        return 'meedule_meetingbundle_closetype';
    }
}
