<?php

namespace Shanbo\ImmobilierBundle\Repository;

use Shanbo\ImmobilierBundle\Entity\ShBien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ShBien|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShBien|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShBien[]    findAll()
 * @method ShBien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShBienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShBien::class);
    }

    /**
     * @param $value
     * @param string $sort
     * @return ShBien[] Returns an array of ShBien objects
     */
    public function findByNatureOrderByPrice($value, $sort = 'ASC')
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.nature_code = :val')
            ->setParameter('val', $value)
            ->leftJoin('s.financier', 'f')
            ->orderBy('f.prix', $sort)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param $nature
     * @param $types
     * @param string $priceMin
     * @param string $priceMax
     * @param string $surfaceMin
     * @param string $surfaceMax
     * @param string $sort
     * @return ShBien[] Returns an array of ShBien objects
     */
    public function findByOrderByPrice($nature, $types, $priceMin='min', $priceMax='max', $surfaceMin='min', $surfaceMax='max', $sort = 'ASC')
    {
        $entityManager = $this->getEntityManager();
        $priceMin = ($priceMin == 'min') ? '' : ' AND f.prix >= ' .$priceMin;
        $priceMax = ($priceMax == 'max') ? '' : ' AND f.prix <= ' .$priceMax;
        $surfaceMin = ($surfaceMin == 'min') ? '' : ' AND c.surface >= ' .$surfaceMin;
        $surfaceMax = ($surfaceMax == 'max') ? '' : ' AND c.surface <= ' .$surfaceMax;

        $q = 'SELECT s
            FROM Shanbo\ImmobilierBundle\Entity\ShBien s
            INNER JOIN s.financier f
            INNER JOIN s.caracteristique c'
        ;
        $q .= ' WHERE ';
        foreach ($types as $type) {
            $q .= '(s.nature_code = ' . $nature . ' AND s.type_code = ' . $type .$priceMin.$priceMax.$surfaceMin.$surfaceMax.')';
            $q .= ' or ';
        }
        $q = substr($q, 0, - 4);
        $q .= ' ORDER BY f.prix ' . $sort;
        $query = $entityManager->createQuery($q);
        return $query->getResult();
    }

    // /**
    //  * @return ShBien[] Returns an array of ShBien objects
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
    public function findOneBySomeField($value): ?ShBien
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
