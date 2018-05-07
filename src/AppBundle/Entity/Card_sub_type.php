<?php

namespace AppBundle\Entity;
use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="card_sub_type")
 */
class Card_sub_type
{
    /**
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
      * @ORM\Column(type="string", length=100)
    */
    private $description;
 
     /**
     * @ORM\Column(name="price", type="bigint")
     */
    private $price;
      /**
     * @ORM\ManyToOne(targetEntity="Card_type", inversedBy="id")
     * @ORM\Column(name="type", type="bigint", nullable=true)
     */
    private $type;

     /**
      * @ORM\Column(name="transport_type", type="bigint")
     */
    private $transport_type;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $start_time;
   

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
     * Set description
     *
     * @param string $description
     *
     * @return Card_sub_type
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Card_sub_type
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Card_sub_type
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set transportType
     *
     * @param integer $transportType
     *
     * @return Card_sub_type
     */
    public function setTransportType($transportType)
    {
        $this->transport_type = $transportType;

        return $this;
    }

    /**
     * Get transportType
     *
     * @return integer
     */
    public function getTransportType()
    {
        return $this->transport_type;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     *
     * @return Card_sub_type
     */
    public function setStartTime($startTime)
    {
        $this->start_time = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->start_time;
    }
}
