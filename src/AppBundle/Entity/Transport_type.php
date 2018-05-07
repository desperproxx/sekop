<?php

namespace AppBundle\Entity;
use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="transport_type")
 */
class Transport_type
{
    /**
     * @ORM\OneToMany(targetEntity="Card_types", mappedBy="transport_type",cascade={"persist", "remove"})
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $trans_type;



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
     * Set transType
     *
     * @param string $transType
     *
     * @return Transport_type
     */
    public function setTransType($transType)
    {
        $this->trans_type = $transType;

        return $this;
    }

    /**
     * Get transType
     *
     * @return string
     */
    public function getTransType()
    {
        return $this->trans_type;
    }
}
