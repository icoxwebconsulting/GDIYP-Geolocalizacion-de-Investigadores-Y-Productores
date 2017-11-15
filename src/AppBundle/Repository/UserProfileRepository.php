<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserProfileRepository extends EntityRepository
{
    public function findAllUserProfiles()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('up', 'u','n', 'a', 'i','k', 'ka')
            ->from('AppBundle:UserProfile', 'up')
            ->innerJoin('up.user', 'u')
            ->leftJoin('u.news', 'n')
            ->innerJoin('up.address', 'a')
            ->innerJoin('up.institution', 'i')
            ->innerJoin('up.knowledge', 'k')
            ->innerJoin('k.knowledge_area', 'ka')
            ->andWhere('up.address IS NOT NULL');

        return $qb->getQuery()->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
    }
    
    public function findAllUsersByCity($city)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('up', 'u','n', 'a', 'i','k', 'ka')
            ->from('AppBundle:UserProfile', 'up')
            ->innerJoin('up.user', 'u')
            ->leftJoin('u.news', 'n')
            ->innerJoin('up.address', 'a')
            ->innerJoin('up.institution', 'i')
            ->innerJoin('up.knowledge', 'k')
            ->innerJoin('k.knowledge_area', 'ka')
            ->andWhere('up.address IS NOT NULL')
            ->andWhere('up.residence_place = :city')
            ->setParameter(':city', $city);

        return $qb->getQuery()->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
    }

    public function findByFilter($city,$institution, $knowledge, $study)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $query = $qb->select('up', 'u','n', 'a', 'i','k', 'ka')
            ->from('AppBundle:UserProfile', 'up')
            ->innerJoin('up.user', 'u')
            ->leftJoin('u.news', 'n')
            ->innerJoin('up.address', 'a')
            ->innerJoin('up.institution', 'i')
            ->innerJoin('up.knowledge', 'k')
            ->innerJoin('k.knowledge_area', 'ka');

            
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
        
        return $query->getQuery()->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
    }

    public function findAllLatestUserNews()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('n')
            ->from('AppBundle:News', 'n')            
            ->join('AppBundle:UserProfile','up','WITH','up.user = n.created_by')
            ->andWhere('n.created < CURRENT_DATE()') 
            ->andWhere('n.created >= DATE_SUB(CURRENT_DATE(), 7, \'day\')');

        return $qb->getQuery()->getResult();
    }    
}