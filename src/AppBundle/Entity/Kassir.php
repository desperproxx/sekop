<?php

namespace AppBundle\Entity;
use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="kassir")
 */
class Kassir
{
    /**
     * @ORM\OneToMany(targetEntity="Stats_sales", mappedBy="kassir_id",cascade={"persist", "remove"})
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
     /**
     * @ORM\Column(name="kass_num", type="bigint")
     */
    private $kass_num;
    /**
     * @ORM\Column(name="name",type="string", length=100, nullable=true)
     */
    private $name;
    /**
     * @ORM\Column(name="second_name",type="string", length=100, nullable=true)
     */
    private $second_name;
     /**
     * @ORM\ManyToOne(targetEntity="Agents", inversedBy="id")
     * @ORM\Column(name="agent_id", type="bigint")
     */
    private $agent_id;



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
     * Set kassNum
     *
     * @param integer $kassNum
     *
     * @return Kassir
     */
    public function setKassNum($kassNum)
    {
        $this->kass_num = $kassNum;

        return $this;
    }

    /**
     * Get kassNum
     *
     * @return integer
     */
    public function getKassNum()
    {
        return $this->kass_num;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Kassir
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set secondName
     *
     * @param string $secondName
     *
     * @return Kassir
     */
    public function setSecondName($secondName)
    {
        $this->second_name = $secondName;

        return $this;
    }

    /**
     * Get secondName
     *
     * @return string
     */
    public function getSecondName()
    {
        return $this->second_name;
    }

    /**
     * Set agentId
     *
     * @param integer $agentId
     *
     * @return Kassir
     */
    public function setAgentId($agentId)
    {
        $this->agent_id = $agentId;

        return $this;
    }

    /**
     * Get agentId
     *
     * @return integer
     */
    public function getAgentId()
    {
        return $this->agent_id;
    }
}
