<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsersRepository")
 */
class Users implements UserInterface, \Serializable
{
    //public function __construct()
    //{
       // $this->isActive = false;
        //$this->notify = false;
   // }

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, name="email")
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string")
     */
    private $salt;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $fio;

    /**
     * @ORM\Column(type="date")
     */
    private $created;

    /**
     * @ORM\Column(type="string")
     */
    private $phone;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Department")
     * @ORM\JoinColumn(name="department", referencedColumnName="id")
     */
    public $department;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Role")
     * @ORM\JoinColumn(name="role", referencedColumnName="role")
     */
    public $role;

    public function getEmail()
    {
        return $this->email;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return $this->salt;
    }

    public function getFIO()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return $this->fio;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return array($this->role);
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function getPhone()
    {
        return $this->phone;
    }
    public function eraseCredentials()
    {
    }


    public function getRoleName()
    {
        return $this->role->getName();
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            // see section on salt below
            $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            // see section on salt below
            $this->salt,
            ) = unserialize($serialized);
    }

    public function getUsername()
    {
        return $this->email;
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
     * Set email
     *
     * @param string $email
     *
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return Users
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Set fio
     *
     * @param string $fio
     *
     * @return Users
     */
    public function setFio($fio)
    {
        $this->fio = $fio;

        return $this;
    }

    /**
     * Set department
     *
     * @param int $department
     *
     * @return Users
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return int
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return Users
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Users
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Set phone
     *
     * @param \DateTime $created
     *
     * @return Users
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /*public function _toString()
    {
        return (string) $this->role;
    }*/
}
