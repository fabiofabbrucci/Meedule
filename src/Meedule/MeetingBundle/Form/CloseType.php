<?php

namespace Meedule\MeetingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Meedule\MeetingBundle\Form\Type\DoodleType;
use Meedule\MeetingBundle\Form\Type\MailType;
use Doctrine\ORM\EntityRepository;

class CloseType extends AbstractType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('AgendaTopics', 'collection', array(
                'type' => new TopicApproveType(),
                'label' => 'paperino',
            ))
            ->add('CrewTopics', 'collection', array(
                'type' => new TopicApproveType(),
            ))
        ;
    }

    public function getName()
    {
        return 'meedule_meetingbundle_closetype';
    }
}
