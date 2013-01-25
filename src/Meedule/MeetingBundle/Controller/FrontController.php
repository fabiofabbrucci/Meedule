<?php

namespace Meedule\MeetingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FrontController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Route("/test", name="test")
     * @Template()
     */
    public function testAction()
    {
        return array();
    }
    
    /**
     * @Route("/cv", name="cv")
     * @Route("/cv-fabio-fabbrucci", name="cvfabio")
     * @Template()
     */
    public function cvAction()
    {
        return array();
    }
}
