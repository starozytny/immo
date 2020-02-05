<?php

namespace App\Repository;

use App\Entity\ShStatGlobal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ShStatGlobal|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShStatGlobal|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShStatGlobal[]    findAll()
 * @method ShStatGlobal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShStatGlobalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShStatGlobal::class);
    }

    // /**
    //  * @return ShStatGlobal[] Returns an array of ShStatGlobal objects
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
    public function findOneBySomeField($value): ?ShStatGlobal
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
