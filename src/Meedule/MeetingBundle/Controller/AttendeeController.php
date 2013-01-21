<?php

namespace Meedule\MeetingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Meedule\MeetingBundle\Entity\Meeting;
use Meedule\MeetingBundle\Entity\Attendee;
use Meedule\MeetingBundle\Form\MeetingType;
use Meedule\MeetingBundle\Form\AgendaType;
use Meedule\MeetingBundle\Form\AttendeeType;

/**
 * Meeting controller.
 *
 * @Route("/meeting/{slug}/attendee")
 */
class AttendeeController extends Controller
{
    /**
     * @Route("/create", name="meeting_attendee_create")
     * @Method("post")
     */
    public function createAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $meeting = $em->getRepository('MeeduleMeetingBundle:Meeting')->findOneBySlugpublic($slug);
        if (!$meeting) {
            throw $this->createNotFoundException('Unable to find Meeting entity.');
        }
        $this->create($meeting);
        return $this->redirect($this->generateUrl('meeting_show', array('slug' => $meeting->getSlugpublic())));
    }
    
    /**
     * @Route("/create_from_admin", name="meeting_attendee_create_from_admin")
     * @Method("post")
     */
    public function createFromAdminAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $meeting = $em->getRepository('MeeduleMeetingBundle:Meeting')->findOneBySlugprivate($slug);
        if (!$meeting) {
            throw $this->createNotFoundException('Unable to find Meeting entity.');
        }
        $this->create($meeting);
        return $this->redirect($this->generateUrl('meeting_admin', array('slug' => $meeting->getSlugprivate())));
    }
    
    private function create($meeting)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity  = new Attendee();
        $request = $this->getRequest();
        $form    = $this->createForm(new AttendeeType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $this->get('session')->setFlash('notice', '<b>' . $entity->getName() . '</b> parteciperà al meeting <em>' . $meeting->getTitle() . '</em>');
            $entity->setMeeting($meeting);
            $em->persist($entity);
            $em->flush();
        }
    }
    
    /**
     * @return view
     * @throws no exists
     * 
     * @Route("/{id}/delete", name="meeting_attendee_delete")
     * @Method({"POST"})
     */
    public function deleteAction($slug, $id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $meeting = $em->getRepository('MeeduleMeetingBundle:Meeting')->findOneBySlugpublic($slug);
        if (!$meeting) {
            throw $this->createNotFoundException('Unable to find Meeting entity.');
        }
        $this->delete($meeting, $id);
        return $this->redirect($this->generateUrl('meeting_show', array('slug' => $slug)));
    }
    
    /**
     * @return view
     * @throws no exists
     * 
     * @Route("/{id}/delete_from_admin", name="meeting_attendee_delete_from_admin")
     * @Method({"POST"})
     */
    public function deleteAdminAction($slug, $id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $meeting = $em->getRepository('MeeduleMeetingBundle:Meeting')->findOneBySlugprivate($slug);
        if (!$meeting) {
            throw $this->createNotFoundException('Unable to find Meeting entity.');
        }
        $this->delete($meeting, $id);
        return $this->redirect($this->generateUrl('meeting_admin', array('slug' => $slug)));
    }
    
    public function delete($meeting, $id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $attendee = $em->getRepository('MeeduleMeetingBundle:Attendee')->find($id);
        if (!$user) {
            throw $this->createNotFoundException('Unable to find Attendee entity.');
        }
        
        if(!$meeting->hasAttendee($attendee)) {
            throw $this->createNotFoundException('This attendee is not part of this meeting');
        }

        $form = $this->createDeleteForm($attendee->getId());
        $request = $this->getRequest();
        $form->bindRequest($request);

        if ($form->isValid()) {
            $this->get('session')->setFlash('notice', '<b>' . $attendee->getName() . '</b> è stato rimosso dal meeting <em>' . $meeting->getTitle() . '</em>');
            $em->remove($attendee);
            $em->flush();
        }
    }
    
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

