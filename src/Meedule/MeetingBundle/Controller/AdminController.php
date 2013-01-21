<?php

namespace Meedule\MeetingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Meedule\MeetingBundle\Entity\Meeting;
use Meedule\MeetingBundle\Entity\Attendee;
use Meedule\MeetingBundle\Entity\Topic;
use Meedule\MeetingBundle\Entity\Reference;

use Meedule\MeetingBundle\Form\MeetingType;
use Meedule\MeetingBundle\Form\AgendaType;
use Meedule\MeetingBundle\Form\AttendeeType;
use Meedule\MeetingBundle\Form\TopicType;
use Meedule\MeetingBundle\Form\TopicPublicType;
use Meedule\MeetingBundle\Form\CloseType;
use Meedule\MeetingBundle\Form\ReferenceType;

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
        
        if($entity->isClosed())
        {
            return array(
                'entity' => $entity,
                'slug' => $entity->getSlugprivate(),
                'topics_agenda' => $entity->getAgendaTopics(),
                'topics_crew'      => $entity->getCrewTopics(),
                'attendees' => $entity->getAttendees(),
                'references' => $entity->getReferences(),
                'url_delete_reference' => '',
                'url_delete_topic_crew' => '',
            );  
        }
        
        $attendee = new Attendee;
        if($this->isLogged()){
            $user = $this->container->get('security.context')->getToken()->getUser();
            $attendee->setName($user->getUsername());
            $attendee->setMail($user->getEmail());
        }
        $create_form   = $this->createForm(new AttendeeType(), $attendee);
        $topic = new Topic;
        if($this->isLogged()){
            $user = $this->container->get('security.context')->getToken()->getUser();
            $topic->setOwner($user->getUsername());
        }
        $create_topic_public_form   = $this->createForm(new TopicPublicType(), $topic);
        $create_topic_form   = $this->createForm(new TopicType(), $topic);
        $reference = new Reference();
        $reference_form = $this->createForm(new ReferenceType(), $reference);
        
        $attendees = array();
        foreach($entity->getAttendees() as $i=>$attendee){
            $attendees[] = $attendee;
            $form = $this->createDeleteForm($attendee->getId());
            $attendees[$i]->setDeleteForm($form->createView());
        }
        
        $crew_topics = array();
        foreach($entity->getCrewTopics() as $i=>$topic){
            $crew_topics[] = $topic;
            $form = $this->createDeleteForm($topic->getId());
            $crew_topics[$i]->setDeleteForm($form->createView());
        }
        
        $agenda_topics = array();
        foreach($entity->getAgendaTopics() as $i=>$topic){
            $agenda_topics[] = $topic;
            $form = $this->createDeleteForm($topic->getId());
            $agenda_topics[$i]->setDeleteForm($form->createView());
        }
        
        $references = array();
        foreach($entity->getReferences() as $i=>$reference){
            $references[] = $reference;
            $form = $this->createDeleteForm($reference->getId());
            $references[$i]->setDeleteForm($form->createView());
        }

        return array(
            'entity' => $entity,
            'form'        => $create_form->createView(),
            
            'form_create_topic_agenda' => $create_topic_form->createView(),
            'form_create_topic_crew' => $create_topic_public_form->createView(),
            'form_reference' => $reference_form->createView(),
            'attendees' => $attendees,
            'references' => $references,
            
            'topics_agenda' => $agenda_topics,
            'topics_crew'      => $crew_topics,
            
            'slug' =>               $entity->getSlugprivate(),
            'url_create_attendee' => 'meeting_attendee_create_from_admin',
            'url_delete_attendee' => 'meeting_attendee_delete_from_admin',
            'url_create_topic_agenda' => 'meeting_topic_agenda_create_from_admin',
            'url_delete_topic_agenda' => 'meeting_topic_admin_delete',
            'url_create_topic_crew' => 'meeting_topic_crew_create_from_admin',
            'url_delete_topic_crew' => 'meeting_topic_admin_delete',
            'url_create_reference' => 'meeting_reference_create_from_admin',
            'url_delete_reference' => 'meeting_reference_delete_from_admin',
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
    
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * @Route("/finalize", name="meeting_admin_finalize")
     * @Template()
     */
    public function finalizeAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $meeting = $em->getRepository('MeeduleMeetingBundle:Meeting')->findOneBySlugprivate($slug);

        if (!$meeting) {
            throw $this->createNotFoundException('Unable to find Meeting entity.');
        }
        
        $form = $this->createForm(new CloseType(), $meeting);
        
        return array(
            'entity' => $meeting,
            'form' => $form->createView(),
        );
    }
    
    /**
     * @Route("/close", name="meeting_admin_close")
     * @Method("post")
     * @Template("MeeduleMeetingBundle:Admin:finalize.html.twig")
     */
    public function closeAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('MeeduleMeetingBundle:Meeting')->findOneBySlugprivate($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Meeting entity.');
        }

        $form   = $this->createForm(new CloseType(), $entity);
        $request = $this->getRequest();
        $form->bindRequest($request);

        if ($form->isValid()) {
            $entity->setClosed(true);
            $entity->setClosedAt(new \DateTime);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Il tuo meeting è stato chiuso.');

            return $this->redirect($this->generateUrl('meeting_admin', array('slug' => $entity->getSlugprivate())));
            
        }

        return array(
            'entity' => $entity,
        );
    }
    
    public function isLogged()
    {
        return $this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY');
    }
}
