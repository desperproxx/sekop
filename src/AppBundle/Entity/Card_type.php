<?php

namespace AppBundle\Entity;
use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="card_type")
 */
class Card_type
{
    /**
     * @ORM\OneToMany(targetEntity="Card_sub_type", mappedBy="type",cascade={"persist", "remove"})
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
    * @ORM\Column(name="c_type", type="bigint")
     */
    private $c_type;



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
     * Set cType
     *
     * @param integer $cType
     *
     * @return Card_type
     */
    public function setCType($cType)
    {
        $this->c_type = $cType;

        return $this;
    }

    /**
     * Get cType
     *
     * @return integer
     */
    public function getCType()
    {
        return $this->c_type;
    }
}
