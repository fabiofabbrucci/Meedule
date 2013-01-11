<?php

namespace Meedule\MeetingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Meedule\MeetingBundle\Entity\Meeting;
use Meedule\MeetingBundle\Entity\User;
use Meedule\MeetingBundle\Entity\Topic;
use Meedule\MeetingBundle\Form\MeetingType;
use Meedule\MeetingBundle\Form\AgendaType;
use Meedule\MeetingBundle\Form\AttendeeType;
use Meedule\MeetingBundle\Form\TopicType;
use Meedule\MeetingBundle\Form\TopicPublicType;

/**
 * Meeting controller.
 *
 * @Route("/meeting/{slug}/topic")
 */
class TopicController extends Controller
{
    /**
     * @Route("/create", name="meeting_topic_create")
     * @Method("post")
     */
    public function createAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $meeting = $em->getRepository('MeeduleMeetingBundle:Meeting')->findOneBySlugprivate($slug);
        if (!$meeting) {
            throw $this->createNotFoundException('Unable to find Meeting entity.');
        }
        $topic = new Topic();
        $form    = $this->createForm(new TopicType(), $topic);
        $this->create($meeting, $form, $topic);
        return $this->redirect($this->generateUrl('meeting_agenda', array('slug' => $meeting->getSlugprivate())));
    }
    
    /**
     * @Route("/create_from_show", name="meeting_topic_show_create")
     * @Method("post")
     */
    public function createFromShowAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $meeting = $em->getRepository('MeeduleMeetingBundle:Meeting')->findOneBySlugpublic($slug);
        if (!$meeting) {
            throw $this->createNotFoundException('Unable to find Meeting entity.');
        }
        $topic = new Topic();
        $form    = $this->createForm(new TopicPublicType(), $topic);
        if(!$topic->getName()){
            $this->get('session')->setFlash('warning', 'Devi specificare il tuo nome');
        }else{
            $this->create($meeting, $form, $topic);
        }
        return $this->redirect($this->generateUrl('meeting_show', array('slug' => $slug)));
    }
    
    /**
     * @Route("/create_agenda_from_admin", name="meeting_topic_agenda_create_from_admin")
     * @Method("post")
     */
    public function createAgendaFromAdminAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $meeting = $em->getRepository('MeeduleMeetingBundle:Meeting')->findOneBySlugprivate($slug);
        if (!$meeting) {
            throw $this->createNotFoundException('Unable to find Meeting entity.');
        }
        $topic = new Topic();
        $form    = $this->createForm(new TopicType(), $topic);
        $this->create($meeting, $form, $topic);
        return $this->redirect($this->generateUrl('meeting_admin', array('slug' => $slug)));
    }
    
    /**
     * @Route("/create_crew_from_admin", name="meeting_topic_crew_create_from_admin")
     * @Method("post")
     */
    public function createCrewFromAdminAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $meeting = $em->getRepository('MeeduleMeetingBundle:Meeting')->findOneBySlugprivate($slug);
        if (!$meeting) {
            throw $this->createNotFoundException('Unable to find Meeting entity.');
        }
        $topic = new Topic();
        $form    = $this->createForm(new TopicPublicType(), $topic);
        $this->create($meeting, $form, $topic);
        return $this->redirect($this->generateUrl('meeting_admin', array('slug' => $slug)));
    }
    
    private function create($meeting, $form, $topic)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        
        $form->bindRequest($request);

        if ($form->isValid()) {
            if(!$topic->getOwner()){
                $topic->setPosition(count($meeting->getAgendaTopics()) + 1);
            }else{
                $topic->setPosition(count($meeting->getCrewTopics()) + 1);
            }
            $topic->setMeeting($meeting);
            $meeting->addTopic($topic);
            $em->persist($topic);
            $em->flush();
        }
    }
    
    /**
     * @return view
     * @throws no exists
     * 
     * @Route("/{id}/delete", name="meeting_topic_delete")
     * @Method({"POST"})
     */
    public function deleteAction($slug, $id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $meeting = $em->getRepository('MeeduleMeetingBundle:Meeting')->findOneBySlugprivate($slug);
        if (!$meeting) {
            throw $this->createNotFoundException('Unable to find Meeting entity.');
        }
        $this->delete($meeting, $id);
        return $this->redirect($this->generateUrl('meeting_agenda', array('slug' => $slug)));
    }
    
    /**
     * @return view
     * @throws no exists
     * 
     * @Route("/{id}/delete_from_show", name="meeting_topic_show_delete")
     * @Method({"POST"})
     */
    public function deleteShowAction($slug, $id)
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
     * @Route("/{id}/delete_from_admin", name="meeting_topic_admin_delete")
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

        $topic = $em->getRepository('MeeduleMeetingBundle:Topic')->find($id);
        if (!$topic) {
            throw $this->createNotFoundException('Unable to find Topic entity.');
        }
        
        $form = $this->createDeleteForm($topic->getId());
        $request = $this->getRequest();
        $form->bindRequest($request);

        if ($form->isValid()) {
            $this->get('session')->setFlash('notice', 'Cancellato');
            $em->remove($topic);
            $em->flush();
        }
    }
    
    /**
     * Order tasks
     * 
     * @return view
     * @throws no exists
     * 
     * @Route("/order", name="meeting_topic_order")
     * @Method({"POST"})
     * @Template()
     */
    public function orderAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $meeting = $em->getRepository('MeeduleMeetingBundle:Meeting')->findOneBySlugprivate($slug);
        if (!$meeting) {
            throw $this->createNotFoundException('Unable to find Meeting entity.');
        }

        foreach($this->getRequest()->get('topic') as $index => $id_topic){
            $topic = $em
                ->getRepository('MeeduleMeetingBundle:Topic')
                ->find($id_topic);
            if($topic and $topic->getMeeting()->getId() == $meeting->getId()){
                $topic->setPosition($index+1);
                $em->persist($topic);
                $em->flush();
            }else{
                throw $this->createNotFoundException('Unable to find Topic entity.');
            }
        }
        return array();
    }
    
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

