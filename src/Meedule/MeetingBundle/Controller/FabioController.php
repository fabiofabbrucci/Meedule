<?php

namespace Meedule\MeetingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Meedule\MeetingBundle\Entity\Meeting;

/**
 * Meeting controller.
 *
 * @Route("/fabio")
 */
class FabioController extends Controller
{
    /**
     * @Route("/meetings", name="fabio_meetings")
     * @Template()
     */
    public function meetingsAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('MeeduleMeetingBundle:Meeting')->findBy(array(), array('id' => 'desc'));

        return array(
            'entities' => $entities,
        );
    }
}
