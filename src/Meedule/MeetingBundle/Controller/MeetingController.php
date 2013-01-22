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
use Meedule\MeetingBundle\Form\TopicPublicType;
use Meedule\MeetingBundle\Form\ReferenceType;

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
        $create_attendee_form   = $this->createForm(new AttendeeType(), $attendee);
        $topic = new Topic;
        if($this->isLogged()){
            $user = $this->container->get('security.context')->getToken()->getUser();
            $topic->setOwner($user->getUsername());
        }
        $create_topic_form   = $this->createForm(new TopicPublicType(), $topic);
        $reference = new Reference();
        $reference_form = $this->createForm(new ReferenceType(), $reference);

        $attendees = array();
        foreach($entity->getAttendees() as $i=>$attendee){
            $attendees[] = $attendee;
            if(!$attendee->getUser()){
                $form = $this->createDeleteForm($attendee->getId());
                $attendees[$i]->setDeleteForm($form->createView());
            }elseif($this->isLogged()){
                $user = $this->container->get('security.context')->getToken()->getUser();
                if($attendee->getUser() == $user) {
                    $form = $this->createDeleteForm($attendee->getId());
                    $attendees[$i]->setDeleteForm($form->createView());
                }
            }
        }
        
        $topics = array();
        foreach($entity->getCrewTopics() as $i=>$topic){
            $topics[] = $topic;
            if(!$topic->getUser()){
                $form = $this->createDeleteForm($topic->getId());
                $topics[$i]->setDeleteForm($form->createView());
            }elseif($this->isLogged()){
                $user = $this->container->get('security.context')->getToken()->getUser();
                if($topic->getUser() == $user) {
                    $form = $this->createDeleteForm($topic->getId());
                    $topics[$i]->setDeleteForm($form->createView());
                }
            }
        }
        
        $references = array();
        foreach($entity->getReferences() as $i=>$reference){
            $references[] = $reference;
            $form = $this->createDeleteForm($reference->getId());
            $references[$i]->setDeleteForm($form->createView());
        }

        return array(
            'entity'      => $entity,
            'form'        => $create_attendee_form->createView(),
            'form_create_topic_crew' => $create_topic_form->createView(),
            'form_reference' => $reference_form->createView(),
            'attendees'   => $attendees,
            'references' => $references,
 
            'topics_agenda' => $entity->getAgendaTopics(),
            'topics_crew'      => $topics,
            
            'slug' =>               $entity->getSlugpublic(),
            'url_create_attendee' => 'meeting_attendee_create',
            'url_delete_attendee' => 'meeting_attendee_delete',
            'url_create_topic_agenda' => '',
            'url_delete_topic_agenda' => '',
            'url_create_topic_crew' => 'meeting_topic_show_create',
            'url_delete_topic_crew' => 'meeting_topic_show_delete',
            'url_create_reference' => 'meeting_reference_create',
            'url_delete_reference' => 'meeting_reference_delete',
        );
    }
    
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    public function isLogged()
    {
        return $this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY');
    }
}
