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


        $visitor = new User();
        $visitor->setUsername('visitor2');
        $visitor->setPlainPassword('visitor2');
        $visitor->setEmail('mathieu2.chabas@outlook.com');
        $visitor->setFirstname('Dupont2');
        $visitor->setLastname('Dupont2');
        $visitor->setEnabled(true);
        $manager->persist($visitor);

        $visitor = new User();
        $visitor->setUsername('visitor3');
        $visitor->setPlainPassword('visitor3');
        $visitor->setEmail('mathieu3.chabas@outlook.com');
        $visitor->setFirstname('Dupont3');
        $visitor->setLastname('Dupont3');
        $visitor->setEnabled(true);
        $manager->persist($visitor);

        $visitor = new User();
        $visitor->setUsername('visitor4');
        $visitor->setPlainPassword('visitor4');
        $visitor->setEmail('mathieu4.chabas@outlook.com');
        $visitor->setFirstname('Dupont4');
        $visitor->setLastname('Dupont4');
        $visitor->setEnabled(true);
        $manager->persist($visitor);

        $visitor = new User();
        $visitor->setUsername('visitor5');
        $visitor->setPlainPassword('visitor5');
        $visitor->setEmail('mathieu5.chabas@outlook.com');
        $visitor->setFirstname('Dupont5');
        $visitor->setLastname('Dupont5');
        $visitor->setEnabled(true);
        $manager->persist($visitor);

        $manager->flush();
    }
}