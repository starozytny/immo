<?php

namespace App\Repository;

use App\Entity\ShAgence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ShAgence|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShAgence|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShAgence[]    findAll()
 * @method ShAgence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShAgenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShAgence::class);
    }

    // /**
    //  * @return ShAgence[] Returns an array of ShAgence objects
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
    public function findOneBySomeField($value): ?ShAgence
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
