<?php

namespace GiftBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('GiftBundle:Default:index.html.twig');

    }

    /**
     * @Route("/events")
     */
    public function eventsAction()
    {
        $user = $this->getUser();

        $events = $this->getDoctrine()
            ->getRepository('GiftBundle:UserEvent')
            ->getEventsByUser($user);

        return $this->render('GiftBundle:Default:events.html.twig', array(
            'events' => $events
        ));
    }

    /**
     * @Route("/add-event")
     */
    public function addEvent(){

        return $this->render('GiftBundle:Default:addEvent.html.twig', array(

        ));
    }
}
