<?php

/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 13/01/16
 * Time: 10:31
 */
namespace GiftBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GiftBundle\Entity\User;
use GiftBundle\Entity\Event;
use GiftBundle\Entity\UserEvent;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        //$userAdmin->setPassword('$2a$04$m3JSssF2nmcdtcij/6qsLOgd7tXTSHDmJi0.nFGPoSUVQpcosIwqa');
        $userAdmin->setPlainPassword('admin');
        $userAdmin->setEmail('mathieu.chabas@gmail.com');
        $userAdmin->setFirstname('Mathieu');
        $userAdmin->setLastname('Chabas');
        $userAdmin->setEnabled(true);

        $visitor = new User();
        $visitor->setUsername('visitor');
        $visitor->setPlainPassword('visitor');
        $visitor->setEmail('mathieu.chabas@outlook.com');
        $visitor->setFirstname('Dupont');
        $visitor->setLastname('Dupont');
        $visitor->setEnabled(true);

        $manager->persist($userAdmin);
        $manager->persist($visitor);

        $event = new Event();
        $event->setName('Anniversaire');
        $date = new \DateTime('2018-10-10 08:00:00');
        $event->setStartDate($date);
        $event->setOwner($userAdmin);

        $userEvent = new UserEvent();
        $userEvent->setUser($userAdmin);
        $userEvent->setEvent($event);

        $manager->persist($event);
        $manager->persist($userEvent);

        $event = new Event();
        $event->setName('Marathon');
        $date = new \DateTime('2016-10-10 10:00:00');
        $event->setStartDate($date);
        $event->setOwner($visitor);

        $userEvent = new UserEvent();
        $userEvent->setUser($visitor);
        $userEvent->setEvent($event);

        $manager->persist($event);
        $manager->persist($userEvent);

        $manager->flush();
    }
}