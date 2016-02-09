<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Menu
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="for_today", type="boolean")
     */
    private $forToday;

    /**
     * @var array
     *
     * @ORM\Column(name="notify_plate", type="array")
     */
    private $notifyPlate;

    public function __construct(){
        $this->notifyPlate = array();
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Menu
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Menu
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set forToday
     *
     * @param boolean $forToday
     * @return Menu
     */
    public function setForToday($forToday)
    {
        $this->forToday = $forToday;

        return $this;
    }

    /**
     * Get forToday
     *
     * @return boolean 
     */
    public function getForToday()
    {
        return $this->forToday;
    }

    /**
     * Set notifyPlate
     *
     * @param array $notifyPlate
     * @return Menu
     */
    public function setNotifyPlate($notifyPlate)
    {
        $this->notifyPlate = $notifyPlate;

        return $this;
    }

    /**
     * Get notifyPlate
     *
     * @return array 
     */
    public function getNotifyPlate()
    {
        return $this->notifyPlate;
    }

    public function pushNotifyPlate($plate){
        array_push($this->notifyPlate, $plate);
    }
}
