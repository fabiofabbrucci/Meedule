<?php

namespace Meedule\MeetingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AgendaType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
    }

    public function getName()
    {
        return 'meedule_meetingbundle_agendatype';
    }
}
