<?php

namespace App\Repository;

use App\Entity\SensorValueBreakpoints;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SensorValueBreakpoints|null find($id, $lockMode = null, $lockVersion = null)
 * @method SensorValueBreakpoints|null findOneBy(array $criteria, array $orderBy = null)
 * @method SensorValueBreakpoints[]    findAll()
 * @method SensorValueBreakpoints[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SensorValueBreakpointsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SensorValueBreakpoints::class);
    }

    // /**
    //  * @return SensorValueBreakpoints[] Returns an array of SensorValueBreakpoints objects
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
    public function findOneBySomeField($value): ?SensorValueBreakpoints
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
