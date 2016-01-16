<?php

namespace GiftBundle\Controller;

use GiftBundle\Entity\Event;
use GiftBundle\Entity\UserEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GiftBundle\Form;
use Symfony\Component\HttpFoundation\Request;

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
    public function addEvent(Request $request){

        $event = new Event();
        $userEvent = new UserEvent();

        $form = $this->get('form.factory')->create(new Form\CreateEventType(), $event);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $user = $this->getUser();
            $userEvent = new UserEvent();
            $userEvent->setEvent($event);
            $userEvent->setUser($user);

            $event->setOwner($user);
            $em->persist($event);
            $em->persist($userEvent);
            $em->flush();
        }

        return $this->render('GiftBundle:Default:addEvent.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
