<?php

namespace Meedule\MeetingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TopicPublicType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'attr' => array('placeholder' => 'Anailisi della pubblicità'),
            ))
            ->add('owner','text', array(
                'required' => true,
                'attr' => array('placeholder' => 'Mario Rossi'),
            ))
        ;
    }

    public function getName()
    {
        return 'meedule_meetingbundle_topicpublictype';
    }
}
