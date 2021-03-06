<?php

namespace GiftBundle\Repository;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * UserEventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserEventRepository extends \Doctrine\ORM\EntityRepository
{
    public function getEventsByUser($user){

        $qb = $this->_em->createQueryBuilder();
        $events = $qb
            ->select('ue')
            ->from('GiftBundle\Entity\UserEvent', 'ue')
            ->leftJoin('ue.event','e')
            ->andWhere('ue.user = :user')
            ->andWhere('e.startdate > :now')
            ->setParameters(array(
                'now' => new \DateTime(),
                'user' => $user))
            ->getQuery()
            ->getResult();

        return $events;
    }

    public function getUsersByEvent($event){

        $qb = $this->_em->createQueryBuilder();
        $users = $qb
            ->select('ue')
            ->from('GiftBundle\Entity\UserEvent', 'ue')
            ->leftJoin('ue.user','u')
            ->andWhere('ue.event = :event')
            ->setParameters(array(
                'event' => $event))
            ->getQuery()
            ->getResult();

        return $users;
    }
}
