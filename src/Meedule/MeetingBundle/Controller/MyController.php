<?php

namespace Meedule\MeetingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Meedule\MeetingBundle\Entity\Meeting;
use Meedule\MeetingBundle\Entity\Topic;
use Meedule\MeetingBundle\Entity\Reference;

/**
 * Meeting controller.
 *
 * @Route("/my")
 */
class MyController extends Controller
{
    /**
     * @Route("/meedules", name="my_meedules")
     * @Template()
     */
    public function meedulesAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $meetings1 = $em->getRepository('MeeduleMeetingBundle:Meeting')->findByOwner($user->getId());
        $meetings2 = $em->getRepository('MeeduleMeetingBundle:Meeting')->findByMail($user->getEmail());
        
        $meetings = array_merge($meetings1, $meetings2);
        foreach($meetings as $i => $meeting){
            foreach( $meetings as $y => $mee){
                if($mee->getId() == $meeting->getId() and $i!=$y){
                    unset($meetings[$i]);
                }
            }
        }
        
        usort($meetings, function($a, $b){  
            return $a->getDate() < $b->getDate();
        });

        return array(
            'meetings' => $meetings,
        );
    }
    
    /**
     * @Route("/partecipations", name="my_partecipations")
     * @Template()
     */
    public function partecipationsAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $meetings = $em->getRepository('MeeduleMeetingBundle:Meeting')->findByAttendee($user->getId(), $user->getEmail());

        if (!$meetings) {
            throw $this->createNotFoundException('Unable to find Meeting entity.');
        }
        
        return array(
            'meetings' => $meetings,
        );
    }
}
