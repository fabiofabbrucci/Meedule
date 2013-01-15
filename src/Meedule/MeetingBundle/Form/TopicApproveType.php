<?php

namespace Meedule\MeetingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TopicApproveType extends AbstractType
{
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Meedule\MeetingBundle\Entity\Topic',
        );
    }
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('approved')
        ;
    }

    public function getName()
    {
        return 'meedule_meetingbundle_topicapprovetype';
    }
}
