<?
namespace Meedule\MeetingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MailType extends AbstractType
{
    public function getParent(array $options)
    {
        return 'email';
    }

    public function getName()
    {
        return 'mail';
    }
}