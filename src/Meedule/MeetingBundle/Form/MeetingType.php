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
            ->add('date', 'date', array(
                'format' => 'dd/MMM/yyyy',
                'years' => array(date('Y'), date('Y')+1, date('Y')+2, date('Y')+3, date('Y')+4),
            ))
            ->add('time','time',array(
                'hours' => array(8,9,10,11,12,13,14,15,16,17,18,19,20,21),
                'minutes' => array(0,15,30,45),
            ))
            ->add('duration', 'choice', array(
                'required' => false,
                'choices' => array(
                    '10' => '10 minuti',
                    '20' => '20 minuti',
                    '30' => '30 minuti',
                    '60' => '1 ora', 
                    '90' => '1 ora e mezza', 
                    '120' => '2 ore',
                    '180' => '3 ore',
                    )
            ))
            ->add('address', 'text', array(
                'required' => false
            ))
            ->add('email', 'email')
            ->add('name')
            ->add('description')
        ;
    }

    public function getName()
    {
        return 'meedule_meetingbundle_meetingtype';
    }
}
