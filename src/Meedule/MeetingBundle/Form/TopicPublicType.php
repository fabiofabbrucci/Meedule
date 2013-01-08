<?php

namespace Meedule\MeetingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TopicPublicType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('owner','text', array('required' => true))
        ;
    }

    public function getName()
    {
        return 'meedule_meetingbundle_topicpublictype';
    }
}
