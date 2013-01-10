<?
namespace Meedule\MeetingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DoodleType extends AbstractType
{
    public function getParent(array $options)
    {
        return 'url';
    }

    public function getName()
    {
        return 'doodle';
    }
}