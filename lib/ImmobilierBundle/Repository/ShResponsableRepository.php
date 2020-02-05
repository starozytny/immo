<?php

namespace Shanbo\ImmobilierBundle\Repository;

use Shanbo\ImmobilierBundle\Entity\ShResponsable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ShResponsable|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShResponsable|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShResponsable[]    findAll()
 * @method ShResponsable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShResponsableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShResponsable::class);
    }

    // /**
    //  * @return ShResponsable[] Returns an array of ShResponsable objects
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
    public function findOneBySomeField($value): ?ShResponsable
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
