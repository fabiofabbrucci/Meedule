<?php

namespace Meedule\MeetingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AttendeeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'attr' => array('placeholder' => 'Mario Rossi'),
            ))
            ->add('mail', 'text', array(
                'required' => false,
                'attr' => array('placeholder' => 'mario@mariorossi.it'),
            ))
        ;
    }

    public function getName()
    {
        return 'meedule_meetingbundle_attendeetype';
    }
}
