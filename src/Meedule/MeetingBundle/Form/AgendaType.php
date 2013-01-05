<?php

namespace Meedule\MeetingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AgendaType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('topic1')
            ->add('topic2')
            ->add('topic3')
            ->add('topic4')
            ->add('topic5')
            ->add('topic6')
            ->add('topic7')
            ->add('topic8')
            ->add('topic9')
            ->add('topic10')
        ;
    }

    public function getName()
    {
        return 'meedule_meetingbundle_agendatype';
    }
}
