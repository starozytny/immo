<?php

namespace Shanbo\ImmobilierBundle\Repository;

use Shanbo\ImmobilierBundle\Entity\ShFinancier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ShFinancier|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShFinancier|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShFinancier[]    findAll()
 * @method ShFinancier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShFinancierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShFinancier::class);
    }

    // /**
    //  * @return ShFinancier[] Returns an array of ShFinancier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ShFinancier
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
