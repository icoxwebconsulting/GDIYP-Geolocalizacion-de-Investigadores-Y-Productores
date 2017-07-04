<?php

namespace AppBundle\Repository;
use Doctrine\ORM\Query\Expr\Join;

/**
 * AgroecologicalPracticeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AgroecologicalPracticeRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllNewsByPractice($practice)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('n')
            ->from('AppBundle:News', 'n')            
            ->join('AppBundle:AgroecologicalPracticeNews','pn','WITH','n.id = pn.news')
            ->andWhere('pn.agroecological_practice = :practice')
            ->setParameter(':practice', $practice);

        return $qb->getQuery()->getResult();
    }

    public function deleteAllNewsByPractice($practice)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->delete('AppBundle:AgroecologicalPracticeNews','pn')
            ->andWhere('pn.agroecological_practice = :practice')
            ->setParameter(':practice', $practice);

        return $qb->getQuery()->execute();
    }

    public function findAllPractices()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('p')
            ->from('AppBundle:AgroecologicalPractice', 'p')
            ->andWhere('p.address IS NOT NULL');

        return $qb->getQuery()->getResult();
    }
    
    public function findAllPracticesByCity($city)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('p')
            ->from('AppBundle:AgroecologicalPractice', 'p')
            ->andWhere('p.city = :city')
            ->setParameter(':city', $city);

        return $qb->getQuery()->getResult();
    }

    public function findByFilter($city, $practice_type, $productionCategory, $productionType, $productionDestination, $whereTheySell, $productiveSurface, $marketWhereSold, $type, $periodicity, $serviceType, $projectType, $promotionType)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $query = $qb->select('p')
            ->from('AppBundle:AgroecologicalPractice', 'p');
            
        if ($city != 0){
            $query->andWhere('p.city = :city');
            $query->setParameter(':city', $city);
        }

        $query->andWhere('p.address IS NOT NULL');
        
        if ($practice_type=="productive_undertaking") {            
            $query->andWhere('p.productive_undertaking IS NOT NULL');
            $query->join('AppBundle:ProductiveUndertaking','pu','WITH','p.productive_undertaking = pu.id');            

            if ($productionCategory != 0){
                $query->andWhere('pu.category = :productionCategory');
                $query->setParameter(':productionCategory', $productionCategory);
            }
            if ($productionType != 0){
                $query->andWhere('pu.type = :productionType');
                $query->setParameter(':productionType', $productionType);
            }
            if ($productionDestination != 0){
                $query->andWhere('pu.productionDestination = :productionDestination');
                $query->setParameter(':productionDestination', $productionDestination);
            }
            if ($whereTheySell != '0'){
                $query->andWhere('pu.whereTheySell = :whereTheySell');
                $query->setParameter(':whereTheySell', $whereTheySell);
            }
            if ($productiveSurface != '0'){
                $query->andWhere('pu.productiveSurface = :productiveSurface');
                $query->setParameter(':productiveSurface', $productiveSurface);
            }
        }
        else if ($practice_type=="marketing_spaces") {
            $query->andWhere('p.marketing_spaces IS NOT NULL');
            $query->join('AppBundle:MarketingSpaces','ms','WITH','p.marketing_spaces = ms.id');

            if ($marketWhereSold != '0') {
                $query->andWhere('ms.marketWhereSold LIKE :marketWhereSold');
                $query->setParameter(':marketWhereSold', '%'.$marketWhereSold.'%');
            }
            if ($type != '0') {
                $query->andWhere('ms.type LIKE :type');
                $query->setParameter(':type', '%'.$type.'%');
            }
            if ($periodicity != '0') {
                $query->andWhere('ms.periodicity LIKE :periodicity');
                $query->setParameter(':periodicity', '%'.$periodicity.'%');
            }            
        }
        else if ($practice_type=="professional_services") {
            $query->andWhere('p.professional_services IS NOT NULL');
            $query->join('AppBundle:ProfessionalServices','ps','WITH','p.professional_services = ps.id');

            if ($serviceType != '0') {
                $query->andWhere('ps.type LIKE :serviceType');
                $query->setParameter(':serviceType', '%'.$serviceType.'%');                
            }
        }
        else if ($practice_type=="institutional_project") {
            $query->andWhere('p.institutional_project IS NOT NULL');
            $query->join('AppBundle:InstitutionalProject','ip','WITH','p.institutional_project = ip.id');

            if ($projectType != '0') {
                $query->andWhere('ip.type LIKE :projectType');
                $query->setParameter(':projectType', '%'.$projectType.'%');                
            }
        }
        else if ($practice_type=="promotion_group") {
            $query->andWhere('p.promotion_group IS NOT NULL');
            $query->join('AppBundle:PromotionGroup','pg','WITH','p.promotion_group = pg.id');

            if ($promotionType != '0') {
                $query->andWhere('pg.type LIKE :promotionType');
                $query->setParameter(':promotionType', '%'.$promotionType.'%');                
            }
        }                
        
        return $query->getQuery()->getResult();
    }
    
}
