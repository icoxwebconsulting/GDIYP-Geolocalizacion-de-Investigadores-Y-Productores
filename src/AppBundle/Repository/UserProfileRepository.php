<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserProfileRepository extends EntityRepository
{
    public function findAllUserProfiles()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('up')
            ->from('AppBundle:UserProfile', 'up')
            ->andWhere('up.address IS NOT NULL');

        return $qb->getQuery()->getResult();
    }
    
    public function findAllUsersByCity($city)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('up')
            ->from('AppBundle:UserProfile', 'up')
            ->andWhere('up.residence_place = :city')
            ->setParameter(':city', $city);

        return $qb->getQuery()->getResult();
    }

    public function findByFilter($city,$institution, $knowledge, $study)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $query = $qb->select('up')
            ->from('AppBundle:UserProfile', 'up');
            
        if ($city != 0){
            $query->andWhere('up.residence_place = :city');
            $query->setParameter(':city', $city);
        }
        if ($institution != 0){
            $query->andWhere('up.institution = :institution');
            $query->setParameter(':institution', $institution);
        }
        if ($knowledge != 0){
            $query->andWhere('up.knowledge = :knowledge');
            $query->setParameter(':knowledge', $knowledge);
        }
        if ($study != 0){
            $query->andWhere('up.study_topic = :study');
            $query->setParameter(':study', $study);
        }
        
        $query->andWhere('up.address IS NOT NULL');
        
        return $query->getQuery()->getResult();
    }
}