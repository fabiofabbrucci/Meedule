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
            $entity->generateSlugs();
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

        $form   = $this->createForm(new AgendaType(), $entity);
        return array(
            'entity' => $entity,
            'form'   => $form->createView()
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

        $form   = $this->createForm(new AgendaType(), $entity);
        $request = $this->getRequest();
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $message = \Swift_Message::newInstance()
                ->setSubject('Meedule: '  . $entity->getTitle())
                ->setFrom(array('fabio.fabbrucci@gmail.com' => 'Meedule'))
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
        );
    }
}

