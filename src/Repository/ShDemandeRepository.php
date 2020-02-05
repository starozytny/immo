<?php

namespace App\Repository;

use App\Entity\ShDemande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ShDemande|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShDemande|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShDemande[]    findAll()
 * @method ShDemande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShDemandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShDemande::class);
    }

    // /**
    //  * @return ShDemande[] Returns an array of ShDemande objects
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
    public function findOneBySomeField($value): ?ShDemande
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
