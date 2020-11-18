<?php

namespace App\Repository;

use App\Entity\Actionchips;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Actionchips|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actionchips|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actionchips[]    findAll()
 * @method Actionchips[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActionchipsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Actionchips::class);
    }

    // /**
    //  * @return Actionchips[] Returns an array of Actionchips objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Actionchips
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
