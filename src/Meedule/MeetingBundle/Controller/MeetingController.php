<?php

namespace Meedule\MeetingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Meedule\MeetingBundle\Entity\Meeting;
use Meedule\MeetingBundle\Entity\User;
use Meedule\MeetingBundle\Form\MeetingType;
use Meedule\MeetingBundle\Form\AgendaType;
use Meedule\MeetingBundle\Form\AttendeeType;

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
        
        $user = new User;
        $create_form   = $this->createForm(new AttendeeType(), $user);
        $attendees = array();
        
        foreach($entity->getAttendees() as $i=>$attendee){
            $attendees[] = $attendee;
            $form = $this->createDeleteForm($attendee->getId());
            $attendees[$i]->setDeleteForm($form->createView());
        }

        return array(
            'entity'      => $entity,
            'form'        => $create_form->createView(),
            'attendees'   => $attendees,
        );
    }
    
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
