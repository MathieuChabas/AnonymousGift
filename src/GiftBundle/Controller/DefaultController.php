<?php

namespace GiftBundle\Controller;

use GiftBundle\Entity\Event;
use GiftBundle\Entity\UserEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GiftBundle\Form\Type;
use Symfony\Component\HttpFoundation\Request;
use GiftBundle\GiftsDistribution\Distribution;

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
     * @Route("/list-events")
     */
    public function eventsAction()
    {
        $user = $this->getUser();

        $events = $this
            ->getDoctrine()
            ->getRepository('GiftBundle:UserEvent')
            ->getEventsByUser($user);

        return $this->render('GiftBundle:Default:listEvents.html.twig', array(
            'events' => $events
        ));
    }

    /**
     * @Route("/add-event")
     */
    public function addEventAction(Request $request){

        $event = new Event();

        $form = $this->get('form.factory')->create(new Type\CreateEventType(), $event);

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

            return $this->redirect($this->generateUrl('gift_default_events'));

        } else {
            return $this->render('GiftBundle:Default:addEvent.html.twig', array(
                'form' => $form->createView()
            ));
        }
    }

    /**
     * @Route("/event-{eventId}")
     */
    public function singleEventAction(Request $request){
        $eventId = $request->get('eventId');

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('GiftBundle:Event');

        $event = $repository->find($eventId);

        $userEvents = $this
            ->getDoctrine()
            ->getRepository('GiftBundle:UserEvent')
            ->getUsersByEvent($event);

        $currentUser = $this->getUser();
        $isOwner = false;
        if($event->getOwner()->getId() == $currentUser->getId()){
            $isOwner = true;
        }
        return $this->render('GiftBundle:Default:singleEvent.html.twig', array(
            'userEvents' => $userEvents,
            'event' => $event,
            'isOwner' => $isOwner,
            'eventId' => $eventId
        ));
    }

    /**
     * @Route("/event-{id}/add-participant")
     *
     */
    public function addParticipantAction(Request $request){
        $eventId = $request->get("id");

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('GiftBundle:Event');

        $event = $repository->find($eventId);

        $form = $this->get('form.factory')->create(new Type\AddParticipantType());

        $user = $this->getUser();

        $data = $request->request->get('giftbundle_form_add_participant');
        $succes = false;

        if(!empty($data)){
            $message = \Swift_Message::newInstance()
                ->setSubject('Anonymous Gift : New Invitation')
                ->setFrom($user->getEmail())
                ->setTo($data['adresseEmail'])
                ->setBody($data['message']);
            $this->get('mailer')->send($message);
            $succes = true;
        }



        return $this->render('GiftBundle:Default:addParticipant.html.twig',array(
            'event' => $event,
            'form' => $form->createView(),
            'user' => $user,
            'succes' => $succes
        ));
    }

    /**
     * @Route("/event/{shared_token}")
     */
    public function registerNewParticipantAction(Request $request){

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('GiftBundle:Event');

        $em = $this->getDoctrine()->getManager();

        $event = $repository->findBy(array('sharedToken' => $request->get("shared_token")));
        $user = $this->getUser();
        $userEvent = new UserEvent();
        $userEvent->setEvent($event[0]);
        $userEvent->setUser($user);

        $UserEventFromDatabase = $em->getRepository('GiftBundle:UserEvent')->findBy(array(
            'user' => $user,
            'event' => $event
        ));
        if($UserEventFromDatabase === null){
            $em->persist($userEvent);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('gift_default_singleevent', array('eventId' => $event[0]->getId())));
    }

    /**
     * @Route("/event-{id}/distribution")
     */
    public function distributionAction(Request $request){
        $em = $this->getDoctrine()->getEntityManager();

        $event = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('GiftBundle:Event')
            ->find($request->get('id'));

        $userEvents = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('GiftBundle:UserEvent')
            ->findBy(array('event' => $event));

        $participants = array();
        foreach($userEvents as $item){
            $participants[] = $item->getUser();
        }

        $distribution = new Distribution($participants);
        $listDistribution = $distribution->distributeGifts();

        foreach($userEvents as $item){
            $item->setReceivedUser($em->getRepository('GiftBundle:User')->find($listDistribution[$item->getUser()->getId()]));
        }
        $em->flush();
        return $this->redirect($this->generateUrl('gift_default_singleevent', array('eventId' => $request->get('id'))));
    }
}
