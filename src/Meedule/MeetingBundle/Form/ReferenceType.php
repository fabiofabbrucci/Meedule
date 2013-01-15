<?php

namespace Meedule\MeetingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ReferenceType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'attr' => array('placeholder' => 'Titolo allegato'),
            ))
            ->add('url', 'url', array(
                'attr' => array('placeholder' => 'http://'),
            ))
        ;
    }

    public function getName()
    {
        return 'meedule_meetingbundle_referencetype';
    }
}
