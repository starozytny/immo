<?php

namespace Shanbo\ImmobilierBundle\Repository;

use Shanbo\ImmobilierBundle\Entity\ShCaracteristique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ShCaracteristique|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShCaracteristique|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShCaracteristique[]    findAll()
 * @method ShCaracteristique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShCaracteristiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShCaracteristique::class);
    }

    // /**
    //  * @return ShCaracteristique[] Returns an array of ShCaracteristique objects
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
    public function findOneBySomeField($value): ?ShCaracteristique
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
