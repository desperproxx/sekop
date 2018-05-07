<?php

namespace AppBundle\Entity;
use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="stats_sales")
 */
class Stats_sales
{
    /**
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Kassir", inversedBy="id")
     * @ORM\Column(name="kassir_id", type="bigint")
     */
    private $kassir_id;

       /**
     * @ORM\Column(name="card_type", type="bigint")
     */
     private $card_type;

     /**
     * @ORM\Column(name="transcount", type="bigint", nullable=true)
     */
    private $transcount;

     /**
     * @ORM\Column(name="transsum", type="bigint", nullable=true)
     */
    private $transsum;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Stats_sales
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
     * Set kassirId
     *
     * @param integer $kassirId
     *
     * @return Stats_sales
     */
    public function setKassirId($kassirId)
    {
        $this->kassir_id = $kassirId;

        return $this;
    }

    /**
     * Get kassirId
     *
     * @return integer
     */
    public function getKassirId()
    {
        return $this->kassir_id;
    }

    /**
     * Set cardType
     *
     * @param integer $cardType
     *
     * @return Stats_sales
     */
    public function setCardType($cardType)
    {
        $this->card_type = $cardType;

        return $this;
    }

    /**
     * Get cardType
     *
     * @return integer
     */
    public function getCardType()
    {
        return $this->card_type;
    }

    /**
     * Set transcount
     *
     * @param integer $transcount
     *
     * @return Stats_sales
     */
    public function setTranscount($transcount)
    {
        $this->transcount = $transcount;

        return $this;
    }

    /**
     * Get transcount
     *
     * @return integer
     */
    public function getTranscount()
    {
        return $this->transcount;
    }

    /**
     * Set transsum
     *
     * @param integer $transsum
     *
     * @return Stats_sales
     */
    public function setTranssum($transsum)
    {
        $this->transsum = $transsum;

        return $this;
    }

    /**
     * Get transsum
     *
     * @return integer
     */
    public function getTranssum()
    {
        return $this->transsum;
    }
}
