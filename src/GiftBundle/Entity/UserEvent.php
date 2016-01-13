<?php

namespace GiftBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserEvent
 *
 * @ORM\Table(name="user_event")
 * @ORM\Entity(repositoryClass="GiftBundle\Repository\UserEventRepository")
 */
class UserEvent
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Event")
     */
    private $event;

    /**
     * @var string
     *
     * @ORM\Column(name="received_user", type="string", length=255, nullable=true)
     */
    private $receivedUser;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return UserEvent
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set event
     *
     * @param string $event
     *
     * @return UserEvent
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set receivedUser
     *
     * @param string $receivedUser
     *
     * @return UserEvent
     */
    public function setReceivedUser($receivedUser)
    {
        $this->receivedUser = $receivedUser;

        return $this;
    }

    /**
     * Get receivedUser
     *
     * @return string
     */
    public function getReceivedUser()
    {
        return $this->receivedUser;
    }
}

