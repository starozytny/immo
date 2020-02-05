<?php

namespace App\Repository;

use App\Entity\ShCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ShCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShCategorie[]    findAll()
 * @method ShCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShCategorie::class);
    }

    // /**
    //  * @return ShCategorie[] Returns an array of ShCategorie objects
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
    public function findOneBySomeField($value): ?ShCategorie
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
