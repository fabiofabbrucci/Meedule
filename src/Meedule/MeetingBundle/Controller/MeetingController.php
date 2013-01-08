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
use Meedule\MeetingBundle\Form\TopicPublicType;

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
        $create_attendee_form   = $this->createForm(new AttendeeType(), $user);
        $topic = new Topic;
        $create_topic_form   = $this->createForm(new TopicPublicType(), $topic);

        $attendees = array();
        foreach($entity->getAttendees() as $i=>$attendee){
            $attendees[] = $attendee;
            $form = $this->createDeleteForm($attendee->getId());
            $attendees[$i]->setDeleteForm($form->createView());
        }
        
        $topics = array();
        foreach($entity->getCrewTopics() as $i=>$topic){
            $topics[] = $topic;
            $form = $this->createDeleteForm($topic->getId());
            $topics[$i]->setDeleteForm($form->createView());
        }

        return array(
            'entity'      => $entity,
            'form'        => $create_attendee_form->createView(),
            'form_create_topic_crew' => $create_topic_form->createView(),
            'attendees'   => $attendees,
 
            'topics_agenda' => $entity->getAgendaTopics(),
            'topics_crew'      => $topics,
            
            'slug' =>               $entity->getSlugpublic(),
            'url_create_attendee' => 'meeting_attendee_create',
            'url_delete_attendee' => 'meeting_attendee_delete',
            'url_create_topic_agenda' => '',
            'url_delete_topic_agenda' => '',
            'url_create_topic_crew' => 'meeting_topic_show_create',
            'url_delete_topic_crew' => 'meeting_topic_show_delete',
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
