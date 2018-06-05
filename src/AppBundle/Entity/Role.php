<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="role")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\RoleRepository")
 */
class Role implements RoleInterface, \Serializable
{
    /**
     * @ORM\Column(type="string", unique=true)
     * @ORM\Id
     */
    private $role;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    public function getRole()
    {
        return $this->role;
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

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setRoles($role)
    {
        $this->role = $role;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->role,
            $this->name,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->role,
            $this->name,
            ) = unserialize($serialized);
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return Role
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->role;
    }
   /* public function __toString()
    {
        return (string) $this->name;
    }*/
}
