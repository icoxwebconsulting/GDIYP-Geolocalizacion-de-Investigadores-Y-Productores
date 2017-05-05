<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class UserRepository extends EntityRepository
{
    public function findAllUsers()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('u')
            ->from('AppBundle:User', 'u')
            ->andWhere('u.enabled = :enabled')
            ->andWhere('u.roles NOT LIKE :roles')
            ->andWhere('u.reported = 0')
            ->setParameter(':enabled', 1)
            ->setParameter('roles','%ROLE_SUPER_ADMIN%');

        return $qb->getQuery()->getResult();
    }
}