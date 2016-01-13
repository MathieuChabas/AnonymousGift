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

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setPassword('$2a$04$m3JSssF2nmcdtcij/6qsLOgd7tXTSHDmJi0.nFGPoSUVQpcosIwqa');
        $userAdmin->setEmail('mathieu.chabas@gmail.com');
        $userAdmin->setFirstname('Mathieu');
        $userAdmin->setLastname('Chabas');
        $userAdmin->setEnabled(true);
        $manager->persist($userAdmin);
        $manager->flush();
    }
}