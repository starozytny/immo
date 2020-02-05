<?php

namespace App\Repository;

use App\Entity\ShCopro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ShCopro|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShCopro|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShCopro[]    findAll()
 * @method ShCopro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShCoproRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShCopro::class);
    }

    // /**
    //  * @return ShCopro[] Returns an array of ShCopro objects
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
    public function findOneBySomeField($value): ?ShCopro
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
