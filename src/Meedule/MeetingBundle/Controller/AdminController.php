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
 * @Route("/meeting/{slug}/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="meeting_admin")
     * @Template()
     */
    public function adminAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('MeeduleMeetingBundle:Meeting')->findOneBySlugprivate($slug);

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
            'entity' => $entity,
            'form'        => $create_form->createView(),
            'attendees' => $attendees,
        );
    }
    
    /**
     * @Route("/edit", name="meeting_admin_edit")
     * @Template()
     */
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('MeeduleMeetingBundle:Meeting')->findOneBySlugprivate($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Meeting entity.');
        }

        $form   = $this->createForm(new MeetingType(), $entity);
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * @Route("/update", name="meeting_admin_update")
     * @Method("post")
     * @Template("MeeduleMeetingBundle:Admin:edit.html.twig")
     */
    public function updateAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('MeeduleMeetingBundle:Meeting')->findOneBySlugprivate($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Meeting entity.');
        }

        $form   = $this->createForm(new MeetingType(), $entity);
        $request = $this->getRequest();
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Il tuo meeting è stato modificato.');

            return $this->redirect($this->generateUrl('meeting_admin', array('slug' => $entity->getSlugprivate())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }
    
    /**
     * @Route("/agenda", name="meeting_admin_agenda")
     * @Template()
     */
    public function agendaAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('MeeduleMeetingBundle:Meeting')->findOneBySlugprivate($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Meeting entity.');
        }

        $form   = $this->createForm(new AgendaType(), $entity);
        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }
    
    /**
     * @Route("/finalize", name="meeting_admin_finalize")
     * @Method("post")
     * @Template("MeeduleMeetingBundle:Admin:agenda.html.twig")
     */
    public function finalizeAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('MeeduleMeetingBundle:Meeting')->findOneBySlugprivate($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Meeting entity.');
        }

        $form   = $this->createForm(new AgendaType(), $entity);
        $request = $this->getRequest();
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'La tua agenda è stata modificata.');

            return $this->redirect($this->generateUrl('meeting_admin', array('slug' => $entity->getSlugprivate())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
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
