<?php

namespace Meedule\MeetingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Meedule\MeetingBundle\Entity\Meeting;
use Meedule\MeetingBundle\Form\MeetingType;
use Meedule\MeetingBundle\Form\AgendaType;

/**
 * Meeting controller.
 *
 * @Route("/meeting")
 */
class MeetingController extends Controller
{
    /**
     * @Route("/", name="meeting")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('MeeduleMeetingBundle:Meeting')->findAll();

        return array('entities' => $entities);
    }

    /**
     * @Route("/{slug}", name="meeting_show")
     * @Template()
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('MeeduleMeetingBundle:Meeting')->findOneBySlugpublic($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Meeting entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
}
