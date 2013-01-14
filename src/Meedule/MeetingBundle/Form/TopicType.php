<?php

namespace Meedule\MeetingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TopicType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'attr' => array('placeholder' => 'Analisi del budget'),
            ))
        ;
    }

    public function getName()
    {
        return 'meedule_meetingbundle_topictype';
    }
}
