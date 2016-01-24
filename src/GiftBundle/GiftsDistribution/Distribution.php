<?php

/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 24/01/16
 * Time: 14:15
 */
namespace GiftBundle\GiftsDistribution;

class Distribution
{
    private $listUsers;
    private $logger;

    /**
     * Distribution constructor.
     * @param $listUsers
     */
    public function __construct($listUsers)
    {
        $this->listUsers = $listUsers;
    }

    public function distributeGifts(){

        $randIndex = rand(1,sizeof($this->listUsers)-1);

        $distribution = array();
        $distribution[$this->listUsers[0]->getId()] = $this->listUsers[$randIndex]->getId();

        $alreadyChosen = array();
        $alreadyChosen[] = $randIndex;

        for($i = 1; $i < sizeof($this->listUsers); $i++){
            $previousIndex = $randIndex;
            if($i != (sizeof($this->listUsers) - 1)) {
                $noRepeat = false;
                while (!$noRepeat) {
                    $randIndex = rand(1, sizeof($this->listUsers)-1);
                    if (!in_array($randIndex, $alreadyChosen)) {
                        $noRepeat = true;
                        $alreadyChosen[] = $randIndex;
                    }
                }
                $distribution[$this->listUsers[$previousIndex]->getId()] = $this->listUsers[$randIndex]->getId();
            } else {
                $distribution[$this->listUsers[$previousIndex]->getId()] = $this->listUsers[0]->getId();
            }
        }
    return $distribution;
    }


}