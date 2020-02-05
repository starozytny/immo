<?php

namespace App\Repository;

use App\Entity\ShImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ShImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShImage[]    findAll()
 * @method ShImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShImage::class);
    }

    // /**
    //  * @return ShImage[] Returns an array of ShImage objects
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
    public function findOneBySomeField($value): ?ShImage
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
