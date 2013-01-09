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
use Meedule\MeetingBundle\Form\TopicType;

/**
 * Meeting controller.
 *
 * @Route("/meeting/creation")
 */
class CreationController extends Controller
{
    /**
     * @Route("/new", name="meeting_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Meeting();
        $entity->setDate(new \DateTime('+1 day'));
        $entity->setTime(new \DateTime);
        $form   = $this->createForm(new MeetingType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * @Route("/create", name="meeting_create")
     * @Method("post")
     * @Template("MeeduleMeetingBundle:Creation:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Meeting();
        $request = $this->getRequest();
        $form    = $this->createForm(new MeetingType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('meeting_agenda', array('slug' => $entity->getSlugprivate())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * @Route("/{slug}/agenda", name="meeting_agenda")
     * @Template()
     */
    public function agendaAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('MeeduleMeetingBundle:Meeting')->findOneBySlugprivate($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Meeting entity.');
        }
        
        $topics = array();
        foreach($entity->getAgendaTopics() as $i=>$topic){
            $topics[] = $topic;
            $form = $this->createDeleteForm($topic->getId());
            $topics[$i]->setDeleteForm($form->createView());
        }

        $topic = new Topic();
        $form_creation   = $this->createForm(new TopicType(), $topic);
        $form_finalize   = $this->createForm(new AgendaType(), $entity);
        return array(
            'entity' => $entity,
            'form_creation'   => $form_creation->createView(),
            'form_finalize'   => $form_finalize->createView(),
            'topics'  => $topics,
            'slug' =>               $entity->getSlugprivate(),
            'url_create_topic_agenda' => 'meeting_topic_create',
            'url_delete_topic_agenda' => 'meeting_topic_delete',
        );
    }
    
    /**
     * @Route("/{slug}/finalize", name="meeting_finalize")
     * @Method("post")
     * @Template("MeeduleMeetingBundle:Creation:agenda.html.twig")
     */
    public function finalizeAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('MeeduleMeetingBundle:Meeting')->findOneBySlugprivate($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Meeting entity.');
        }
        
        if($entity->getAgendaTopics()->count() == 0){
            $this->get('session')->setFlash('warning', 'Specifica almeno un argomento per la tua riunione');
            return $this->redirect($this->generateUrl('meeting_agenda', array('slug' => $entity->getSlugprivate())));
        }

        $form   = $this->createForm(new AgendaType(), $entity);
        $request = $this->getRequest();
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $message = \Swift_Message::newInstance()
                ->setSubject('Meedule: '  . $entity->getTitle())
                ->setFrom(array('meedule@gmail.com' => 'Meedule'))
                ->setTo($entity->getEmail())
                ->setBody(
                    $this->renderView(
                        'MeeduleMeetingBundle:Creation:email.txt.twig',
                        array('entity' => $entity)
                    )
                    , 'text/html'
                )
            ;
            $this->get('mailer')->send($message);
            
            $this->get('session')->setFlash('notice', 'Il tuo meeting è stato creato con successo.');

            return $this->redirect($this->generateUrl('meeting_summary', array('slug' => $entity->getSlugprivate())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }
    
    /**
     * @Route("/{slug}/summary", name="meeting_summary")
     * @Template()
     */
    public function summaryAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('MeeduleMeetingBundle:Meeting')->findOneBySlugprivate($slug);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Meeting entity.');
        }
        
        return array(
            'entity' => $entity,
            'topics' => $entity->getAgendaTopics(),
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

