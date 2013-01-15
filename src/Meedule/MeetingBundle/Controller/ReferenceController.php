<?php

namespace Meedule\MeetingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Meedule\MeetingBundle\Entity\Meeting;
use Meedule\MeetingBundle\Entity\Reference;
use Meedule\MeetingBundle\Form\MeetingType;
use Meedule\MeetingBundle\Form\AgendaType;
use Meedule\MeetingBundle\Form\AttendeeType;
use Meedule\MeetingBundle\Form\ReferenceType;

/**
 * Meeting controller.
 *
 * @Route("/meeting/{slug}/reference")
 */
class ReferenceController extends Controller
{
    /**
     * @Route("/create", name="meeting_reference_create")
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
     * @Route("/create_from_admin", name="meeting_reference_create_from_admin")
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
        $entity  = new Reference();
        $request = $this->getRequest();
        $form    = $this->createForm(new ReferenceType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $entity->setMeeting($meeting);
            $em->persist($entity);
            $em->flush();
        }
    }
    
    /**
     * @return view
     * @throws no exists
     * 
     * @Route("/{id}/delete", name="meeting_reference_delete")
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
     * @Route("/{id}/delete_from_admin", name="meeting_reference_delete_from_admin")
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

        $reference = $em->getRepository('MeeduleMeetingBundle:Reference')->find($id);
        if (!$reference) {
            throw $this->createNotFoundException('Unable to find Reference entity.');
        }
        
        if(!$meeting->hasReference($reference)) {
            throw $this->createNotFoundException('This reference is not part of this meeting');
        }

        $form = $this->createDeleteForm($reference->getId());
        $request = $this->getRequest();
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em->remove($reference);
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

