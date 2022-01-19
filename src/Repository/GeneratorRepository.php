<?php

namespace App\Repository;

use App\Entity\Generator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Generator|null find($id, $lockMode = null, $lockVersion = null)
 * @method Generator|null findOneBy(array $criteria, array $orderBy = null)
 * @method Generator[]    findAll()
 * @method Generator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GeneratorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Generator::class);
    }

    // /**
    //  * @return Generator[] Returns an array of Generator objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Generator
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
