<?php

namespace App\Repository;

use App\Entity\ShDiagnostic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ShDiagnostic|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShDiagnostic|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShDiagnostic[]    findAll()
 * @method ShDiagnostic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShDiagnosticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShDiagnostic::class);
    }

    // /**
    //  * @return ShDiagnostic[] Returns an array of ShDiagnostic objects
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
    public function findOneBySomeField($value): ?ShDiagnostic
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
