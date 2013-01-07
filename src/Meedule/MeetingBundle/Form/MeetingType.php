<?php

namespace Meedule\MeetingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MeetingType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('email', 'email')
            ->add('name')
            ->add('date', 'date', array(
                'format' => 'dd/MM/yyyy',
            ))
            ->add('time')
            ->add('duration', 'choice', array(
                'choices' => array(
                    '10' => '10 minuti',
                    '20' => '20 minuti',
                    '30' => '30 minuti',
                    '60' => '1 ora', 
                    '90' => '1 ora e mezza', 
                    '120' => '2 ore',
                    )
            ))
            ->add('address')
            ->add('description')
        ;
    }

    public function getName()
    {
        return 'meedule_meetingbundle_meetingtype';
    }
}
