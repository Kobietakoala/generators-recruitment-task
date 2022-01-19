<?php

namespace App\Repository;

use App\Entity\Generator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

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

    /**
     * Getting last $max_last_result of generator measurement 
     *
     * @param integer $generator_id
     * @param integer $max_last_results
     * @return Generator[] Returns an array of Generator objects
     */
    public function getByGeneratorId(int $generator_id): Array{
        return $this->createQueryBuilder('g')
            ->andWhere('g.generator_id = :generator_id')
            ->setParameter(':generator_id', $generator_id)
            ->orderBy('g.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Getting list of generator measurement with pagination
     *
     * @param integer $generator_id
     * @param integer $start
     * @param integer $end
     * @param integer $first_result
     * @param integer $max_result
     * @return Generator[] Returns an array of Generator objects
     */
    public function findMeasurementByGeneratorId(int $generator_id, int $start, int $end, int $first_result, int $max_result) :Array{
        return $this->createQueryBuilder('g')
            ->andWhere('g.generator_id = :generator_id')
            ->andWhere('g.time >= :start')
            ->andWhere('g.time <= :end')
            ->setParameter(':generator_id', $generator_id)
            ->setParameter(':start', $start)
            ->setParameter(':end', $end)
            ->setFirstResult($first_result)
            ->setMaxResults($max_result)
            ->orderBy('g.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     *  Getting list of generator measurement
     *
     * @param integer $generator_id
     * @param integer $start
     * @param integer $end
     * @return Generator[] Returns an array of Generator objects
     */
    public function findAllMeasurementByGeneratorId(int $generator_id, int $start, int $end): Array{
        return $this->createQueryBuilder('g')
            ->andWhere('g.generator_id = :generator_id')
            ->andWhere('g.time >= :start')
            ->andWhere('g.time <= :end')
            ->setParameter(':generator_id', $generator_id)
            ->setParameter(':start', $start)
            ->setParameter(':end', $end)
            ->orderBy('g.id', 'DESC')
            ->getQuery()
            ->getResult();
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
