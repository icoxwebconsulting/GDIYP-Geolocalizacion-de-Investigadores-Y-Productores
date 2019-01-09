<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ReportRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReportRepository extends EntityRepository
{
    public function findAllUserReportedByOtherUsers()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('r')
            ->from('AppBundle:Report', 'r')
            ->andWhere('r.created_by IS NOT NULL')
            ->andWhere('r.type = 1');

        return $qb->getQuery()->getResult();
    }
    
    public function findAllUserReported()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('r')
            ->from('AppBundle:Report', 'r')
            ->leftJoin('r.user', 'user')
            ->where('user.deletedAt IS NULL')    
            ->andWhere('r.type = 1');

        return $qb->getQuery()->getResult();
    }
}
