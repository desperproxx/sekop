<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="department")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\RoleDepartment")
 */
class Department
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $department;


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
     * Set department
     *
     * @param string $department
     *
     * @return Department
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
    }
    public function __toString()
    {
        return (string) $this->id;
    }
}

