<?php

namespace AppBundle\Repository;

/**
 * UsersRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;
class UsersRepository extends \Doctrine\ORM\EntityRepository implements UserLoaderInterface
{
	 public function loadUserByUsername($email)
    {
        return $this->createQueryBuilder('u')
            ->join('u.role', 'r')
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
