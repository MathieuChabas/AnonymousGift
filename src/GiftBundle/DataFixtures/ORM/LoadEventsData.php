<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 13/01/16
 * Time: 11:27
 */

namespace GiftBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadEventsData
{
    public function load(ObjectManager $manager)
    {
        $event = new Event();
        $event->setName('Anniversaire');
        $event->setStartDate('10/10/2018');
        $manager->persist($event);
        $manager->flush();
    }
}