<?php

namespace App\Repository;

use App\Entity\DateReset;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DateReset|null find($id, $lockMode = null, $lockVersion = null)
 * @method DateReset|null findOneBy(array $criteria, array $orderBy = null)
 * @method DateReset[]    findAll()
 * @method DateReset[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DateResetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DateReset::class);
    }

    // /**
    //  * @return DateReset[] Returns an array of DateReset objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DateReset
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
